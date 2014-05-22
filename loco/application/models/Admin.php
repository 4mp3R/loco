<?php

/*
 * profile
 * accomodation_type
 * accomodation
 * accomodation_feature
 * accomodation_data
 * contract
 * message
 * photo
 * faq
 *
 * Amministratore deve poter gestire (creare / modificare / cancellare) ::
 *      tipologie degli alloggi
 *      utenti
 * Visualizzare i dati statistici
 *      offerte
 *      numero opzioni da parte dei potenziali locatari
 *      numero alloggi locati
 * Aggiornare la FAQ
 *
 */

class Application_Model_Admin {

    /*
     *  Accomodations managing
     */

    public function listAccomodationTypes() {

    }

    public function getAccomodationType() {

    }

    public function creaAccomodationType() {

    }

    public function editAccomodationType() {

    }

    public function deleteAccomodationType() {

    }

    /*
     * Profiles managing
     */

    public function listProfiles() {

    }

    public function getProfile() {

    }

    public function createProfile() {

    }

    public function editProfile() {

    }

    public function deleteProfile() {

    }

    /*
     * Statistics
     */

    public function getAvailableAccomodations($from_date, $to_date) {

    }

    public function getOptionedAccomodationsNumber($from_date, $to_date) {

    }

    public function getLeasedAccomodationsNumber($from_date, $to_date) {

    }


    /*
     * F.A.Q.
     */

    public function getFaq() {

    }

    public function updateFaq() {

    }

    public function addFaq() {

    }

    public function deleteFaq() {

    }

}