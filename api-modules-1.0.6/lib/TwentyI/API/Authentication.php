<?php
namespace TwentyI\API;

/**
 * Helper class for 20i API calls.
 *
 * @see https://my.20i.com/reseller/api
 *
 * @copyright 2018 20i Limited
 */
class Authentication extends REST
{
    /**
     * @var string The URL to the service. You should not need to change this.
     */
    public static $serviceURL = "https://auth-api.20i.com:3000/";

    /**
     * Returns a new access token for the user. This is suitable for ongoing
     * API use, not interactive (control panel) use.
     *
     * @param string|null $user The user reference, eg. "stack-user:1234"
     * @param string $from_token The original token to derive from (typically a
     * full API access token).
     *
     * @return array {
     *     access_token: string
     *     refresh_token: string|null
     * }
     *
     * @throws \TwentyI\API\HTTPException
     */
    public function apiTokenForUser($user, $from_token)
    {
        if (!$user) {
            throw new \TwentyI\API\HTTPException("User is required");
        }

        if (! is_string($user)) {
            throw new \TwentyI\API\HTTPException("User must be a string");
        }
        return $this->postWithFields("/login/authenticate", [
            "grant_type" => "refresh_token",
            "refresh_token" => $from_token,
            "scope" => $user,
        ]);
    }

    /**
     * Returns a new access token for the user. This is suitable for ongoing
     * API use, not interactive (control panel) use.
     *
     * @param string $user The user reference, eg. "stack-user:1234"
     * @param string[]|null $scopes The scopes to use. Usually unset.
     * @return array {
     *      access_token: string
     *      refresh_token: string|null
     * }
     *
     * @throws \TwentyI\API\HTTPException
     */
    public function controlPanelTokenForUser($user, array $scopes = null)
    {
        if (!$user) {
            throw new \TwentyI\API\HTTPException("User is required");
        }

        if ( !is_string($user)) {
            throw new \TwentyI\API\HTTPException("User must be a string");
        }

        return $this->postWithFields("/login/authenticate", [
            "grant_type" => "client_credentials",
            "scope" => isset($scopes) ?
                $user . "<" . implode(",", $scopes) . ">" :
                $user,
        ]);
    }
}
