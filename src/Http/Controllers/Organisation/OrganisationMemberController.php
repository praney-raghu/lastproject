<?php

namespace Ssntpl\Neev\Http\Controllers\Organisation;

use Illuminate\Http\Request;
use Ssntpl\Neev\Models\User;
use Ssntpl\Neev\Models\Organisation;
use Ssntpl\Neev\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class OrganisationMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the members of the given team.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Organisation $organisation)
    {
        return view('neev::user.organisation.members.list')->with('organisation', $organisation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $team_id
     * @param int $user_id
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Organisation $organisation, User $user)
    {
        if (!auth()->user()->isAdmin($organisation)) {
            abort(403);
        }

        if ($user->getKey() === auth()->user()->getKey()) {
            abort(403);
        }

        $user->detachOrganisation($organisation);

        return redirect(route('organisation.index'));
    }

    // /**
    //  * @param Request $request
    //  * @param int $team_id
    //  * @return $this
    //  */
    // public function invite(Request $request, $team_id)
    // {
    //     $teamModel = config('teamwork.team_model');
    //     $team = $teamModel::findOrFail($team_id);

    //     if (!Teamwork::hasPendingInvite($request->email, $team)) {
    //         Teamwork::inviteToTeam($request->email, $team, function ($invite) {
    //             Mail::send('teamwork.emails.invite', ['team' => $invite->team, 'invite' => $invite], function ($m) use ($invite) {
    //                 $m->to($invite->email)->subject('Invitation to join team ' . $invite->team->name);
    //             });
    //             // Send email to user
    //         });
    //     } else {
    //         return redirect()->back()->withErrors([
    //             'email' => 'The email address is already invited to the team.'
    //         ]);
    //     }

    //     return redirect(route('teams.members.show', $team->id));
    // }

    // /**
    //  * Resend an invitation mail.
    //  *
    //  * @param $invite_id
    //  * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
    //  */
    // public function resendInvite($invite_id)
    // {
    //     $invite = TeamInvite::findOrFail($invite_id);
    //     Mail::send('teamwork.emails.invite', ['team' => $invite->team, 'invite' => $invite], function ($m) use ($invite) {
    //         $m->to($invite->email)->subject('Invitation to join team ' . $invite->team->name);
    //     });

    //     return redirect(route('teams.members.show', $invite->team));
    // }
}
