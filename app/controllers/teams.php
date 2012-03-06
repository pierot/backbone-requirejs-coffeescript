<?php

function teams() {
  $teams = array();
  
  array_push($teams, array('id' => 0, 'name' => 'Reet SK', 'members' => 17));
  array_push($teams, array('id' => 1, 'name' => 'Rupel Boom', 'members' => 23));
  array_push($teams, array('id' => 2, 'name' => 'Aartselaar SK', 'members' => 11));

  return json_encode($teams);
}

function team_post() {
  $data = json_decode(file_get_contents('php://input'));

  return json_encode(array('id' => rand() * 99999, 'name' => $data->name, 'members' => $data->members));
}

function team_update() {
  syslog(LOG_WARNING, $_POST);

  $id = params('id');

  return json_encode(array('id' => $id, 'name' => 'Aartselaar SK', 'members' => 11));
}

function team_get() {
  $id = params('id');

  return json_encode(array('id' => $id, 'name' => 'Aartselaar SK', 'members' => 11));
}
