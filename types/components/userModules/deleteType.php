<?php

require_once '../configModules/database.php';

$deleteTypeQuery = $db->prepare('DELETE from types_types WHERE matchID="'.$_GET['matchId'].'"');
$deleteTypeQuery->execute();

header('Location: userTypes.php');