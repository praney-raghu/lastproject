<?php

namespace Ssntpl\Neev\Models;

use Illuminate\Support\Str;
use Ssntpl\Neev\Facades\Neev;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Ssntpl\Neev\Events\UserLeftOrganisation;
use Ssntpl\Neev\Events\UserJoinedOrganisation;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Ssntpl\Neev\Exceptions\UserNotInOrganisationException;
use Ssntpl\Neev\Notifications\ResetPassword as ResetPasswordNotification;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_id', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $adminRoles = [
        'super_admin',
        'admin',
    ];

    protected $adminPermissions = [
        'manage_users',
        'manage_permissions',
        'impersonate',
    ];

    //region organisational structure

    /**
     * Get the owner organisation of this user.
     */
    public function owner()
    {
        return $this->belongsTo(Organisation::class, 'owner_id');
    }

    public function isSibling(User $user)
    {
        return $this->owner->id == $user->owner->id;
    }

    public function isAdmin($organisation = null)
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: Neev::organisation();

        if ($this->hasRoleInOrganisation($organisation_id, $this->adminRoles) || $this->hasAnyPermissionInOrganisation($organisation_id, $this->adminPermissions)) {
            return true;
        }
        return false;
    }

    /**
     * Get all organisations whose this user is memeber of.
     */
    public function organisations()
    {
        return $this->belongsToMany(Organisation::class)
                        ->withPivot('is_active', 'is_default')
                        ->withTimestamps();
    }
    
    /**
     * Get all organisations whose this user is memeber of.
     */
    public function organisationsOrdered()
    {
        return $this->belongsToMany(Organisation::class)
                        ->withPivot('is_active', 'is_default')
                        ->withTimestamps()
                        ->orderBy('is_default', 'desc');
    }

    /**
     * The current organisation of the user.
     */
    public function getOrganisationAttribute()
    {
        return $this->belongsToMany(Organisation::class)
                        ->withPivot('is_active', 'is_default')
                        ->withTimestamps()
                        ->orderBy('is_default', 'desc')
                        ->limit(1)
                        ->first();
    }

    /**
     * Alias to eloquent many-to-many relation's attach() method.
     *
     * @param mixed $organisation
     * @param bool $is_active
     * @param bool $is_default
     */
    public function attachOrganisation(Organisation  $organisation)
    {
        // Reload relation
        $this->load('organisations');

        if (!$this->organisations->contains($organisation)) {
            $this->organisations()->attach($organisation, [
                'is_active' => true,
                'is_default' => false
            ]);

            event(new UserJoinedOrganisation($this, $organisation));
        } else {
            // Throw exception if user already present in team
            $exception = new UserAlreadyInOrganisationException();
            $exception->setOrganisation($organisation->name);
            throw $exception;
        }

        if ($this->relationLoaded('organisations')) {
            $this->load('organisations');
        }

        if ($this->relationLoaded('organisation')) {
            $this->load('organisation');
        }
    }

    /**
     * Alias to eloquent many-to-many relation's detach() method.
     *
     * @param mixed $organisation
     */
    public function detachOrganisation(Organisation $organisation)
    {
        if (!$this->organisations->contains($organisation)) {
            $exception = new UserNotInOrganisationException();
            $exception->setOrganisation($organisation->name);
            throw $exception;
        }

        $this->organisations()->detach($organisation);

        event(new UserLeftOrganisation($this, $organisation));

        if ($this->relationLoaded('organisations')) {
            $this->load('organisations');
        }

        if ($this->relationLoaded('organisation')) {
            $this->load('organisation');
        }
    }

    /**
     * Switch the current organisation of the user
     *
     * @param object|array|integer $organisation
     * @return $this
     * @throws ModelNotFoundException
     * @throws UserNotInOrganisationException
     */
    public function switchOrganisation(Organisation $organisation)
    {
        if (!$organisation->members->contains($this->getKey())) {
            $exception = new UserNotInOrganisationException();
            $exception->setOrganisation($organisation->name);
            throw $exception;
        }

        DB::table('organisation_user')->where('user_id', $this->getKey())->update(['is_default' => false]);

        $this->organisations()->updateExistingPivot($organisation->getKey(), [
            'is_default' => true,
        ]);

        if ($this->relationLoaded('organisation')) {
            $this->load('organisation');
        }

        if ($this->relationLoaded('organisations')) {
            $this->load('organisations');
        }
    }

    //endregion

    //region Auth methods

    /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = Hash::needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    /**
     * Create the password reset token.
     *
     * @return string
     */
    public function createPasswordResetToken()
    {
        // delete existing user token
        DB::table('password_resets')->where('user_id', $this->id)->delete();

        $key = config('app.key');

        if (Str::startsWith($key, 'base64:')) {
            $key = base64_decode(substr($key, 7));
        }

        // generate new token
        $token = hash_hmac('sha256', Str::random(40), $key);

        // insert new token in table
        DB::table('password_resets')->insert(['user_id' => $this->id, 'token' => Hash::make($token), 'created_at' => new Carbon]);

        return $token;
    }

    /**
     * Verify the password reset token.
     *
     * @param string
     * @return bool
     */
    public function verifyPasswordResetToken($token)
    {
        $record = (array) DB::table('password_resets')->where('user_id', $this->id)->first();

        return $record &&
               !Carbon::parse($record['created_at'])->addSeconds(config('neev.reset_password_token_expire'))->isPast() &&
                 Hash::check($token, $record['token']);
    }

    /**
     * Deletes the password reset token.
     *
     * @return void
     */
    public function deletePasswordResetToken()
    {
        DB::table('password_resets')->where('user_id', $this->id)->delete();
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $ownerDomain = ($this->owner && $this->owner->domain) ? 'http://' . $this->owner->domain : config('app.url');
        $resetUrl = url($ownerDomain . route('password.reset', $token, false));
        $this->notify(new ResetPasswordNotification($resetUrl));
    }

    //endregion

    //region Roles and permission methods

    /**
     * A user may have multiple roles.
     */
    public function roles($organisation = null)
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: Neev::organisation()->id;

        return $this->belongsToMany(Role::class, 'user_roles')
                    ->wherePivot('organisation_id', $organisation_id)
                    ->withPivot('organisation_id');
    }

    /**
     * A user may have multiple direct permissions.
     */
    public function permissions($organisation = null)
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: Neev::organisation()->id;

        return $this->belongsToMany(Permission::class, 'user_permissions')
                    ->wherePivot('organisation_id', $organisation_id);
    }

    /**
     * Grant the given permission(s) to a role.
     *
     * @param string|array|\Spatie\Permission\Contracts\Permission|\Illuminate\Support\Collection $permissions
     *
     * @return $this
     */
    public function givePermissionTo(...$permissions)
    {
        return $this->givePermissionToInOrganisation(Neev::organisation(), ...$permissions);
    }

    public function givePermissionToInOrganisation($organisation, ...$permissions)
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        $permissions = collect($permissions)
            ->flatten()
            ->map(function ($permission) {
                return $this->getStoredPermission($permission);
            })
            ->each(function ($permission) {
                $this->ensureModelSharesGuard($permission);
            })
            ->all();

        foreach ($permissions as $permission) {
            $this->permissions()->attach($permission, ['organisation_id' => $organisation_id]);
        }

        if ($this->relationLoaded('permissions')) {
            $this->load('permissions');
        }

        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Revoke the given permission.
     *
     * @param \Spatie\Permission\Contracts\Permission|string $permission
     *
     * @return $this
     */
    public function revokePermissionTo(...$permissions)
    {
        return $this->revokePermissionToInOrganisation(Neev::organisation(), ...$permissions);
    }

    public function revokePermissionToInOrganisation($organisation, ...$permissions)
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        $permissions = collect($permissions)
            ->flatten()
            ->map(function ($permission) {
                return $this->getStoredPermission($permission);
            })
            ->each(function ($permission) {
                $this->ensureModelSharesGuard($permission);
            })
            ->all();

        $this->permissions()->wherePivot('organisation_id', $organisation_id)->detach($permissions);

        if ($this->relationLoaded('permissions')) {
            $this->load('permissions');
        }

        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Remove all current permissions and set the given ones.
     *
     * @param string|array|\Spatie\Permission\Contracts\Permission|\Illuminate\Support\Collection $permissions
     *
     * @return $this
     */
    public function syncPermissions(...$permissions)
    {
        return $this->syncPermissionsInOrganisation(Neev::organisation(), ...$permissions);
    }

    public function syncPermissionsInOrganisation($organisation, ...$permissions)
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        $this->permissions()->wherePivot('organisation_id', $organisation_id)->detach();

        return $this->givePermissionToInOrganisation($organisation_id, $permissions);
    }

    /**
     * Assign the given role to the model.
     *
     * @param array|string|\Spatie\Permission\Contracts\Role ...$roles
     *
     * @return $this
     */
    public function assignRole(...$roles)
    {
        return $this->assignRoleInOrganisation(Neev::organisation(), ...$roles);
    }

    public function assignRoleInOrganisation($organisation, ...$roles)
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) {
                return $this->getStoredRole($role);
            })
            ->each(function ($role) {
                $this->ensureModelSharesGuard($role);
            })
            ->all();

        foreach ($roles as $role) {
            $this->roles()->attach($role, ['organisation_id' => $organisation_id]);
        }

        if ($this->relationLoaded('roles')) {
            $this->load('roles');
        }

        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Revoke the given role from the model.
     *
     * @param string|\Spatie\Permission\Contracts\Role $role
     */
    public function removeRole(...$roles)
    {
        return $this->removeRoleInOrganisation(Neev::organisation(), ...$roles);
    }

    public function removeRoleInOrganisation($organisation, ...$roles)
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        $roles = collect($roles)
            ->flatten()
            ->map(function ($role) {
                return $this->getStoredRole($role);
            })
            ->each(function ($role) {
                $this->ensureModelSharesGuard($role);
            })
            ->all();

        $this->roles()->wherePivot('organisation_id', $organisation_id)->detach($roles);

        if ($this->relationLoaded('roles')) {
            $this->load('roles');
        }

        $this->forgetCachedPermissions();
    }

    /**
     * Remove all current roles and set the given ones.
     *
     * @param array|\Spatie\Permission\Contracts\Role|string ...$roles
     *
     * @return $this
     */
    public function syncRoles(...$roles)
    {
        return $this->syncRolesInOrganisation(Neev::organisation(), ...$roles);
    }

    public function syncRolesInOrganisation($organisation, ...$roles)
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        $this->roles()->wherePivot('organisation_id', $organisation_id)->detach();

        return $this->assignRoleInOrganisation($organisation_id, $roles);
    }

    /**
     * Determine if the model has (one of) the given role(s).
     *
     * @param string|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles
     * @param string|array|Organisation $organisation
     *
     * @return bool
     */
    public function hasRole($roles): bool
    {
        return $this->hasRoleInOrganisation(Neev::organisation(), $roles);
    }

    public function hasRoleInOrganisation($organisation, $roles): bool
    {
        if (is_null($roles)) {
            return false;
        }

        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        if (is_string($roles) && false !== strpos($roles, '|')) {
            $roles = $this->convertPipeToArray($roles);
        }

        if (is_string($roles)) {
            return $this->roles($organisation_id)->get()->contains('name', $roles);
        }

        if ($roles instanceof Role) {
            return $this->roles($organisation_id)->get()->contains('id', $roles->id);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRoleInOrganisation($organisation_id, $role)) {
                    return true;
                }
            }

            return false;
        }

        return $roles->intersect($this->roles($organisation_id)->get())->isNotEmpty();
    }

    /**
     * Determine if the model has all of the given role(s).
     *
     * @param string|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $roles
     *
     * @return bool
     */
    public function hasAllRoles($roles): bool
    {
        return $this->hasAllRolesInOrganisation(Neev::organisation(), $roles);
    }

    public function hasAllRolesInOrganisation($organisation, $roles): bool
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        if (is_string($roles) && false !== strpos($roles, '|')) {
            $roles = $this->convertPipeToArray($roles);
        }

        if (is_string($roles)) {
            return $this->roles($organisation_id)->get()->contains('name', $roles);
        }

        if ($roles instanceof Role) {
            return $this->roles($organisation_id)->get()->contains('id', $roles->id);
        }

        $roles = collect()->make($roles)->map(function ($role) {
            return $role instanceof Role ? $role->name : $role;
        });

        return $roles->intersect($this->roles($organisation_id)->get()->pluck('name')) == $roles;
    }

    /**
     * Determine if the model may perform the given permission.
     *
     * @param string|\Spatie\Permission\Contracts\Permission $permission
     * @param string|null $guardName
     *
     * @return bool
     */
    public function hasPermissionTo($permission, $guardName = null): bool
    {
        return $this->hasPermissionToInOrganisation(Neev::organisation(), $permission, $guardName);
    }

    public function hasPermissionToInOrganisation($organisation, $permission, $guardName = null): bool
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        if (is_string($permission)) {
            $permission = app(Permission::class)->findByName(
                $permission,
                $guardName ?? $this->getDefaultGuardName()
            );
        }

        return $this->hasDirectPermissionInOrganisation($organisation_id, $permission) || $this->hasPermissionViaRoleInOrganisation($organisation_id, $permission);
    }

    /**
     * Determine if the model has any of the given permissions.
     *
     * @param array ...$permissions
     *
     * @return bool
     */
    public function hasAnyPermission(...$permissions): bool
    {
        return $this->hasAnyPermissionInOrganisation(Neev::organisation(), ...$permissions);
    }

    public function hasAnyPermissionInOrganisation($organisation, ...$permissions): bool
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        if (is_array($permissions[0])) {
            $permissions = $permissions[0];
        }

        foreach ($permissions as $permission) {
            if ($this->hasPermissionToInOrganisation($organisation_id, $permission)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determine if the model has, via roles, the given permission.
     *
     * @param \Spatie\Permission\Contracts\Permission $permission
     *
     * @return bool
     */
    protected function hasPermissionViaRole(Permission $permission): bool
    {
        $this->hasPermissionViaRoleInOrganisation(Neev::organisation(), $permission);
    }

    protected function hasPermissionViaRoleInOrganisation($organisation, Permission $permission): bool
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        return $this->hasRoleInOrganisation($organisation_id, $permission->roles);
    }

    /**
     * Determine if the model has the given permission.
     *
     * @param string|\Spatie\Permission\Contracts\Permission $permission
     *
     * @return bool
     */
    public function hasDirectPermission($permission): bool
    {
        $this->hasDirectPermissionInOrganisation(Neev::organisation(), $permission);
    }

    public function hasDirectPermissionInOrganisation($organisation, $permission): bool
    {
        $organisation_id = (Organisation::retrieveOrganisationId($organisation)) ?: (($this->organisation) ? $this->organisation->id : null);

        if (is_null($organisation_id)) {
            return false;
        }

        if (is_string($permission)) {
            $permission = app(Permission::class)->findByName($permission, $this->getDefaultGuardName());

            if (!$permission) {
                return false;
            }
        }

        return $this->permissions($organisation_id)->get()->contains('id', $permission->id);
    }

    //endregion
}
