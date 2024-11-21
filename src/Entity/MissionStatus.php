<?php
namespace App\Entity;


enum MissionStatus:string {
    Case PENDING = "En Attente";
    Case IN_PROGRESSE = "Commencée";
    Case COMPLETED = "Terminée";
    Case FAIELD = "Echoué";
}