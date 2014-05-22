<?php

class Application_Model_Catalog {

    public function __construct() {

    }

    public function getAllAccomodations() {
        $accomodation = new Application_Model_Resources_Accomodation();
        $profile = new Application_Model_Resources_Profile();

        $profiles = $profile->getAllProfiles();

        $result = array();

        foreach($profiles as $p) {
           $accomodations = $accomodation->getAccomodationsByProfile($p['email']);

            foreach($accomodations as $a) {
                $result[] = (object) array('profile' => $p['email'], 'accomodation' => $a['title']);
            }
        }

        return $result;
    }
}