<?php

namespace Ssntpl\Neev\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Organisation extends Model
{
    use HasRoles;

    protected $guard_name = 'organisation';

    protected $fillable = ['name', 'code', 'domain', 'owner_id'];

    /**
     * @param $organisation
     * @return mixed
     */
    public static function retrieveOrganisationId($organisation)
    {
        if (is_object($organisation) && is_a($organisation, Organisation::class)) {
            return $organisation->getKey();
        }

        if (is_numeric($organisation)) {
            return $organisation;
        }

        if (is_array($organisation) && isset($organisation['id'])) {
            return $organisation['id'];
        }

        return null;
    }

    /**
     * @param $organisation
     * @return mixed
     */
    public static function retrieveOrganisation($organisation)
    {
        if (is_object($organisation) && is_a($organisation, Organisation::class)) {
            return $organisation;
        }

        if (is_numeric($organisation)) {
            return Organisation::find($organisation);
        }

        if (is_array($organisation) && isset($organisation['id'])) {
            return Organisation::find($organisation['id']);
        }

        return null;
    }

    /**
     * @param $name
     * @param $suggestion_count
     * @return string|array
     */
    public static function suggestCode($name, $suggestion_count = 1)
    {
        $names_taken = Organisation::where('code', 'like', "$name%")->get()->pluck('code')->toArray();
        $suggestions = [];
        $count = 0;
        $suggestions_left = $suggestion_count;
        while ($suggestions_left > 0) {
            $count++;

            if (!in_array($name . $count, $names_taken)) {
                $suggestions[] = $name . $count;
                $suggestions_left--;
            }
        }

        if ($suggestion_count == 1) {
            return $suggestions[0];
        }

        return $suggestions;
    }

    /**
     * Get all members of the organisation.
     */
    public function members()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('is_active', 'is_default')
                    ->withTimestamps();
    }

    /**
     * Get the parent organisation.
     */
    public function owner()
    {
        return $this->belongsTo(Organisation::class, 'owner_id');
    }

    /**
     * Get the child organisations.
     */
    public function clients()
    {
        return $this->hasMany(Organisation::class, 'owner_id');
    }

    /**
     * Get all users.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'owner_id');
    }

    public function addMember(User $user)
    {
        $user->attachOrganisation($this);

        if ($this->relationLoaded('users')) {
            $this->load('users');
        }
    }

    public function removeMember($user)
    {
        $user->detachOrganisation($this);

        if ($this->relationLoaded('users')) {
            $this->load('users');
        }
    }

    public function inviteMember($user, callable $success = null)
    {
        // if (is_object($user) && isset($user->email)) {
        //     $email = $user->email;
        // } elseif (is_string($user)) {
        //     $email = $user;
        // } else {
        //     throw new \Exception('The provided object has no "email" attribute and is not a string.');
        // }

        // $invite = $this->app->make(Config::get('teamwork.invite_model'));
        // $invite->user_id = $this->user()->getKey();
        // $invite->team_id = $team;
        // $invite->type = 'invite';
        // $invite->email = $email;
        // $invite->accept_token = md5(uniqid(microtime()));
        // $invite->deny_token = md5(uniqid(microtime()));
        // $invite->save();

        // event(new UserInvitedToOrganisation($invite));

        // if (!is_null($success)) {
        //     return $success($invite);
        // }
    }

    public function activateMember(User $user)
    {
        if (!$this->members->contains($user)) {
            $exception = new UserNotInOrganisationException();
            $exception->setOrganisation($organisation->name);
            throw $exception;
        }

        $this->members()->updateExistingPivot($user->getKey(), [
            'is_active' => true,
        ]);
    }

    public function deactivateMember(User $user)
    {
        if (!$this->members->contains($user)) {
            $exception = new UserNotInOrganisationException();
            $exception->setOrganisation($organisation->name);
            throw $exception;
        }

        $this->members()->updateExistingPivot($user->getKey(), [
            'is_active' => false,
        ]);
    }

    /**
     * An organisation may have multiple direct permissions.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'organisation_permissions');
    }
}
