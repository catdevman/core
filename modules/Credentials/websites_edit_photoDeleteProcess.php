<?php
/*
Gibbon, Flexible & Open School System
Copyright (C) 2010, Ross Parker

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

//Gibbon system-wide includes
include '../../functions.php';
include '../../config.php';

//Module includes
include './moduleFunctions.php';

//New PDO DB connection
$pdo = new Gibbon\sqlConnection();
$connection2 = $pdo->getConnection();

@session_start();

//Set timezone from session variable
date_default_timezone_set($_SESSION[$guid]['timezone']);

$credentialsWebsiteID = $_GET['credentialsWebsiteID'];
$URL = $_SESSION[$guid]['absoluteURL']."/index.php?q=/modules/Credentials/websites_edit.php&credentialsWebsiteID=$credentialsWebsiteID";

if (isActionAccessible($guid, $connection2, '/modules/Credentials/websites_edit.php') == false) {
    $URL .= '&return=error0';
    header("Location: {$URL}");
} else {
    //Proceed!
    //Check if planner specified
    if ($credentialsWebsiteID == '') {
        $URL .= '&return=error1';
        header("Location: {$URL}");
    } else {
        try {
            $data = array('credentialsWebsiteID' => $credentialsWebsiteID);
            $sql = 'SELECT * FROM credentialsWebsite WHERE credentialsWebsiteID=:credentialsWebsiteID';
            $result = $connection2->prepare($sql);
            $result->execute($data);
        } catch (PDOException $e) {
            $URL .= '&return=error2';
            header("Location: {$URL}");
            exit();
        }

        if ($result->rowCount() != 1) {
            $URL .= '&return=error2';
            header("Location: {$URL}");
        } else {
            //UPDATE
            try {
                $data = array('credentialsWebsiteID' => $credentialsWebsiteID);
                $sql = "UPDATE credentialsWebsite SET logo='' WHERE credentialsWebsiteID=:credentialsWebsiteID";
                $result = $connection2->prepare($sql);
                $result->execute($data);
            } catch (PDOException $e) {
                $URL .= '&return=error2';
                header("Location: {$URL}");
                exit();
            }

            $URL .= '&return=success0';
            header("Location: {$URL}");
        }
    }
}
