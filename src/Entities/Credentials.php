<?php

declare(strict_types=1);

namespace Sylapi\Courier\Inpost\Entities;

use Sylapi\Courier\Abstracts\Credentials as CredentialsAbstract;
use OlzaApiClient\Entities\Helpers\HeaderEntity;

class Credentials extends CredentialsAbstract
{
    public function setOrganizationId(string $organizationId): self
    {
        $this->set('organization_id', $organizationId);

        return $this;
    }

    public function getOrganizationId(): string
    {
        return $this->get('organization_id');
    }
}
