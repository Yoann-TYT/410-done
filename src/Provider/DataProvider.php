<?php

namespace App\Provider;

class DataProvider
{
    private $teams;
    private $users;
    public function __construct()
    {
        $this->teams = fopen(__ROOT_DIR__ . "/data/teams.csv", "r");
        $this->users = fopen(__ROOT_DIR__ . "/data/users.csv", "r");
    }

    public function getTeams(): array
    {
        $teams = [];
        while (($data = fgetcsv($this->teams, 1000, ";")) !== FALSE) {
            $teams[trim($data[0])] = $data;
        }
        $headers = array_shift($teams);
        return array_map(function ($team) use ($headers) {
            return array_combine($headers, $team);
        }, $teams);
    }

    public function getUsers(): array
    {
        $users = [];
        while (($data = fgetcsv($this->users, 1000, ";")) !== FALSE) {
            $users[trim($data[0])] = $data;
        }
        $headers = array_shift($users);
        return array_map(function ($team) use ($headers) {
            return array_combine($headers, $team);
        }, $users);
    }

    public function getTeamsWithUsers(): array
    {
        // Fake delay of 30ms
        usleep(30000);
        $teams = $this->getTeams();
        $users = $this->getUsers();
        $teamsWithUsers = [];
        foreach ($teams as $team) {
            $usersUuid = explode(",", $team['members']);
            $usersInTeam = [];
            foreach ($usersUuid as $userUuid) {
                $usersInTeam[] = $users[trim($userUuid)];
            }

            $teamsWithUsers[] = [
                'uuid' => $team['uuid'],
                'name' => $team['name'],
                'users' => $usersInTeam
            ];
        }
        return $teamsWithUsers;
    }
}