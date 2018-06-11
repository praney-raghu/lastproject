<?php

namespace Ssntpl\Neev\Exceptions;

use RuntimeException;

class UserNotInOrganisationException extends RuntimeException
{
    /**
     * Name of the affected organisation
     *
     * @var string
     */
    protected $organisation;

    /**
     * Set the affected organisation
     *
     * @param  string   $organisation
     * @return $this
     */
    public function setOrganisation($organisation)
    {
        $this->organisation = $organisation;

        $this->message = "The user is not in the organisation {$organisation}";

        return $this;
    }

    /**
     * Get the affected organisation.
     *
     * @return string
     */
    public function getOrganisation()
    {
        return $this->organisation;
    }
}
