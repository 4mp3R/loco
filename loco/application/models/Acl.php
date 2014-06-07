<?php

/*
 * Naming convention: "controller_action"
 *                    "controller_compound-name"
 */

class Application_Model_Acl extends Zend_Acl {

    public function __construct() {
        $this->addRole(new Zend_Acl_Role("unregistered"))
            ->addResource(new Zend_Acl_Resource("index_index"))
            ->addResource(new Zend_Acl_Resource("error_error"))
            ->addResource(new Zend_Acl_Resource("error_authorization-error"))
            ->addResource(new Zend_Acl_Resource("loco_index"))
            ->addResource(new Zend_Acl_Resource("loco_support-view"))
            ->addResource(new Zend_Acl_Resource("loco_faq-view"))
            ->addResource(new Zend_Acl_Resource("user_register"))
            ->addResource(new Zend_Acl_Resource("user_login"))
            ->addResource(new Zend_Acl_Resource("user_authenticate"))
            ->allow("unregistered", array(
                "error_error", "loco_index", "loco_faq-view", "user_register", "user_login", "user_authenticate",
                "error_authorization-error", "index_index"
            ));

        $this->addRole(new Zend_Acl_Role("lessee"), "unregistered")
            ->addResource(new Zend_Acl_Resource("accomodation_get"))
            ->addResource(new Zend_Acl_Resource("accomodation_option"))
            ->addResource(new Zend_Acl_Resource("accomodation_deoption"))
            ->addResource(new Zend_Acl_Resource("accomodation_search"))
            ->addResource(new Zend_Acl_Resource("accomodation_view-options"))
            ->addResource(new Zend_Acl_Resource("contract_index"))
            ->addResource(new Zend_Acl_Resource("contract_view"))
            ->addResource(new Zend_Acl_Resource("contract_info-add"))
            ->addResource(new Zend_Acl_Resource("message_getnew"))
            ->addResource(new Zend_Acl_Resource("message_list"))
            ->addResource(new Zend_Acl_Resource("message_add"))
            ->addResource(new Zend_Acl_Resource("message_view"))
            ->addResource(new Zend_Acl_Resource("message_delete"))
            ->addResource(new Zend_Acl_Resource("user_index"))
            ->addResource(new Zend_Acl_Resource("user_logout"))
            ->addResource(new Zend_Acl_Resource("user_profile-view"))
            ->addResource(new Zend_Acl_Resource("user_profile-edit"))
            ->allow("lessee", array(
                "accomodation_get", "accomodation_deoption", "accomodation_option", "accomodation_search", "accomodation_view-options", "contract_index", "contract_view",
                "contract_info-add", "message_getnew", "message_list", "message_add", "message_view", "message_delete",
                "user_index", "user_logout", "user_profile-view", "user_profile-edit"
            ));

        $this->addRole(new Zend_Acl_Role("lesser"), "lessee")
            ->addResource(new Zend_Acl_Resource("accomodation_index"))
            ->addResource(new Zend_Acl_Resource("accomodation_add"))
            ->addResource(new Zend_Acl_Resource("accomodation_edit"))
            ->addResource(new Zend_Acl_Resource("accomodation_delete-photo"))
            ->addResource(new Zend_Acl_Resource("accomodation_delete"))
            ->addResource(new Zend_Acl_Resource("accomodation_lessee-select"))
            ->addResource(new Zend_Acl_Resource("contract_create"))
            ->addResource(new Zend_Acl_Resource("contract_confirm"))
            ->allow("lesser", array(
                "accomodation_index", "accomodation_add", "accomodation_edit", "accomodation_lessee-select", "accomodation_delete-photo", "accomodation_delete", "contract_create", "contract_confirm"
            ));

        $this->addRole(new Zend_Acl_Role("admin"), "lesser")
            ->addResource(new Zend_Acl_Resource("accomodation_type-list"))
            ->addResource(new Zend_Acl_Resource("accomodation_type-add"))
            ->addResource(new Zend_Acl_Resource("accomodation_type-edit"))
            ->addResource(new Zend_Acl_Resource("accomodation_type-delete"))
            ->addResource(new Zend_Acl_Resource("accomodation_view-all"))
            ->addResource(new Zend_Acl_Resource("loco_settings"))
            ->addResource(new Zend_Acl_Resource("loco_statistics"))
            ->addResource(new Zend_Acl_Resource("loco_faq-edit"))
            ->addResource(new Zend_Acl_Resource("loco_faq-modify"))
            ->addResource(new Zend_Acl_Resource("loco_faq-delete"))
            ->addResource(new Zend_Acl_Resource("loco_faq-add"))
            ->addResource(new Zend_Acl_Resource("user_view-all"))
            ->addResource(new Zend_Acl_Resource("user_delete"))
            ->allow("admin", array(
                "accomodation_view-all", "accomodation_type-list", "accomodation_type-add", "accomodation_type-edit", "accomodation_type-delete", "loco_settings", "loco_statistics", "loco_faq-edit", "loco_faq-modify", "loco_faq-delete", "loco_faq-add", "user_view-all", "user_delete"
            ));
    }

}