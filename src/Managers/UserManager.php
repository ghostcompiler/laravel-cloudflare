<?php

namespace Vendor\Cloudflare\Managers;

use Vendor\Cloudflare\DTOs\User;

class UserManager extends AbstractManager
{
    public function get()
    {
        $response = $this->getRequest('user');

        return $this->hydrate($response, function (array $data) {
            return User::fromArray($data['result'] ?? []);
        });
    }

    public function update(array $data)
    {
        $response = $this->patchRequest('user', $data);

        return $this->hydrate($response, function (array $data) {
            return User::fromArray($data['result'] ?? []);
        });
    }

    public function tokens()
    {
        return $this->getRequest('user/tokens');
    }

    public function verifyToken()
    {
        return $this->getRequest('user/tokens/verify');
    }
}
