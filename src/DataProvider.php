<?php

namespace App;

class DataProvider
{
    private $teams;
    private $users;
    public function __construct()
    {
        $this->teams = fopen(ROOT_DIR . "/data/teams.csv", "r");
        $this->users = fopen(ROOT_DIR . "/data/users.csv", "r");
    }

    public function getTeams(): array
    {
        $teams = [];
        while (($data = fgetcsv($this->teams, 1000, ";")) !== FALSE) {
            $teams[trim($data[0])] = $data;
        }
        array_shift($teams);
        return $teams;
    }

    public function getUsers(): array
    {
        $users = [];
        while (($data = fgetcsv($this->users, 1000, ";")) !== FALSE) {
            $users[trim($data[0])] = $data;
        }
        array_shift($users);
        return $users;
    }

    public function getTeamsWithUsers(): array
    {
        $teams = $this->getTeams();
        $users = $this->getUsers();
        $teamsWithUsers = [];
        foreach ($teams as $team) {
            $usersUuid = explode(",", $team[2]);
            $usersInTeam = [];
            foreach ($usersUuid as $userUuid) {
                $usersInTeam[] = $users[trim($userUuid)];
            }

            $teamsWithUsers[$team[0]] = [
                'name' => $team[1],
                'users' => $usersInTeam
            ];
        }
        return $teamsWithUsers;
    }
}