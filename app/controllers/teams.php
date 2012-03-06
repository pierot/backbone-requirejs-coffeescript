<?php

function teams() {
  if(!isset($_SESSION['teams']) || !is_array($_SESSION['teams']) || empty($_SESSION['teams']))
    init_teams();

  return $_SESSION['teams'];
}

function init_teams() {
  $teams = array();

  // default
  array_push($teams, array('id' => 0, 'name' => 'Reet SK', 'members' => 17));
  array_push($teams, array('id' => 1, 'name' => 'Rupel Boom', 'members' => 23));
  array_push($teams, array('id' => 2, 'name' => 'Aartselaar SK', 'members' => 11));

  $_SESSION['teams'] = $teams;
}

function find_team_by_id($id) {
  $teams = teams();

  foreach($teams as $team_id => $team)  {
    if($team['id'] === $id) 
      return $team;
  }

  return NULL;
}

function teams_all() {
  $teams = teams();

  return json_encode($teams);
}

function team_post() {
  $teams = teams();

  $data = json_decode(file_get_contents('php://input'));
  $team = array('id' => rand() * 99999, 'name' => $data->name, 'members' => $data->members);

  array_push($teams, $team);

  return json_encode($team);
}

function team_update() {
  $teams = teams();

  $data = json_decode(file_get_contents('php://input'));
  $id = params('id');

  $team = find_team_by_id($id);
  $team['name'] = $data->name;
  $team['members'] = $data->members;

  return json_encode($team);
}

function team_get() {
  $id = params('id');

  $team = find_team_by_id($id);

  return json_encode($team);
}
