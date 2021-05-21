-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Jeu 03 Mars 2016 à 11:17
-- Version du serveur: 5.5.43
-- Version de PHP: 5.4.39-0+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `nesrine_db_oqna`
--

-- --------------------------------------------------------

--
-- Structure de la table `ip_activites`
--

CREATE TABLE IF NOT EXISTS `ip_activites` (
  `activite_id` int(11) NOT NULL AUTO_INCREMENT,
  `descrip` text NOT NULL,
  `activites_date_created` datetime NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) DEFAULT NULL,
  `adresse_ip` varchar(50) DEFAULT NULL,
  `etat` int(11) NOT NULL,
  PRIMARY KEY (`activite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_clients`
--

CREATE TABLE IF NOT EXISTS `ip_clients` (
  `client_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `client_date_created` datetime DEFAULT NULL,
  `client_date_modified` datetime NOT NULL,
  `client_type` int(11) NOT NULL,
  `client_titre` int(11) NOT NULL,
  `client_name` varchar(100) NOT NULL,
  `client_prenom` varchar(100) NOT NULL,
  `client_date_naiss` date DEFAULT NULL,
  `client_societe` varchar(100) NOT NULL,
  `client_address_1` varchar(100) DEFAULT '',
  `client_address_2` varchar(100) DEFAULT '',
  `client_city` varchar(45) DEFAULT '',
  `client_state` varchar(35) DEFAULT '',
  `client_zip` varchar(15) DEFAULT '',
  `client_country` varchar(35) DEFAULT '',
  `client_devise_id` int(11) DEFAULT NULL,
  `client_phone` varchar(20) DEFAULT '',
  `client_fax` varchar(20) DEFAULT NULL,
  `client_mobile` varchar(20) DEFAULT '',
  `client_email` varchar(100) DEFAULT '',
  `client_web` varchar(100) DEFAULT '',
  `client_vat_id` varchar(100) DEFAULT '',
  `client_tax_code` varchar(100) DEFAULT '',
  `client_mat_fiscal` varchar(100) DEFAULT NULL,
  `client_active` int(1) NOT NULL DEFAULT '1',
  `timbre_fiscale` int(1) NOT NULL DEFAULT '1',
  `delete` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`client_id`),
  KEY `client_active` (`client_active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_client_custom`
--

CREATE TABLE IF NOT EXISTS `ip_client_custom` (
  `client_custom_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`client_custom_id`),
  KEY `client_id` (`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_client_notes`
--

CREATE TABLE IF NOT EXISTS `ip_client_notes` (
  `client_note_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `client_note_date` datetime NOT NULL,
  `client_note` longtext NOT NULL,
  `adr_ip` varchar(50) DEFAULT NULL,
  `usr` varchar(50) DEFAULT NULL,
  `id_usr` int(11) DEFAULT NULL,
  `drap` int(1) DEFAULT '0',
  PRIMARY KEY (`client_note_id`),
  KEY `client_id` (`client_id`,`client_note_date`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_custom_fields`
--

CREATE TABLE IF NOT EXISTS `ip_custom_fields` (
  `custom_field_id` int(11) NOT NULL AUTO_INCREMENT,
  `custom_field_table` varchar(35) NOT NULL,
  `custom_field_label` varchar(64) NOT NULL,
  `custom_field_column` varchar(64) NOT NULL,
  PRIMARY KEY (`custom_field_id`),
  KEY `custom_field_table` (`custom_field_table`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_delai_paiement`
--

CREATE TABLE IF NOT EXISTS `ip_delai_paiement` (
  `delai_paiement_id` int(11) NOT NULL AUTO_INCREMENT,
  `delai_paiement_label` varchar(100) NOT NULL,
  PRIMARY KEY (`delai_paiement_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `ip_delai_paiement`
--

INSERT INTO `ip_delai_paiement` (`delai_paiement_id`, `delai_paiement_label`) VALUES
(1, '30% à la commande'),
(2, '50% à la commande'),
(3, '100% à la commande');

-- --------------------------------------------------------

--
-- Structure de la table `ip_devises`
--

CREATE TABLE IF NOT EXISTS `ip_devises` (
  `devise_id` int(11) NOT NULL AUTO_INCREMENT,
  `devise_label` varchar(100) NOT NULL,
  `devise_symbole` varchar(100) NOT NULL,
  `taux` float DEFAULT NULL,
  `symbole_placement` varchar(20) NOT NULL,
  `number_decimal` int(11) NOT NULL,
  `thousands_separator` varchar(5) NOT NULL,
  PRIMARY KEY (`devise_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `ip_devises`
--

INSERT INTO `ip_devises` (`devise_id`, `devise_label`, `devise_symbole`, `taux`, `symbole_placement`, `number_decimal`, `thousands_separator`) VALUES
(1, 'Dinars', 'DT', 1, 'after', 3, ' ');

-- --------------------------------------------------------

--
-- Structure de la table `ip_droits`
--

CREATE TABLE IF NOT EXISTS `ip_droits` (
  `id_droit` int(11) NOT NULL AUTO_INCREMENT,
  `groupes_user_id` int(11) NOT NULL,
  `nom` varchar(30) NOT NULL,
  `action` varchar(10) NOT NULL,
  PRIMARY KEY (`id_droit`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=318 ;

--
-- Contenu de la table `ip_droits`
--

INSERT INTO `ip_droits` (`id_droit`, `groupes_user_id`, `nom`, `action`) VALUES
(229, 1, 'contact', 'add'),
(230, 1, 'contact', 'del'),
(231, 1, 'contact', 'index'),
(232, 1, 'devis', 'add'),
(233, 1, 'devis', 'del'),
(234, 1, 'devis', 'index'),
(235, 1, 'facture', 'add'),
(236, 1, 'facture', 'del'),
(237, 1, 'facture', 'index'),
(238, 1, 'product', 'add'),
(239, 1, 'product', 'del'),
(240, 1, 'product', 'index'),
(241, 1, 'fournisseur', 'add'),
(242, 1, 'fournisseur', 'del'),
(243, 1, 'fournisseur', 'index'),
(244, 1, 'payement', 'add'),
(245, 1, 'payement', 'del'),
(246, 1, 'payement', 'index'),
(247, 1, 'report', 'add'),
(248, 1, 'report', 'del'),
(249, 1, 'report', 'index'),
(250, 1, 'setting', 'add'),
(251, 1, 'setting', 'del'),
(252, 1, 'setting', 'index'),
(306, 4, 'contact', 'add'),
(307, 4, 'contact', 'del'),
(308, 4, 'contact', 'index'),
(309, 4, 'devis', 'add'),
(310, 4, 'devis', 'del'),
(311, 4, 'devis', 'index'),
(312, 4, 'product', 'add'),
(313, 4, 'product', 'del'),
(314, 4, 'product', 'index'),
(315, 4, 'fournisseur', 'add'),
(316, 4, 'fournisseur', 'del'),
(317, 4, 'fournisseur', 'index');

-- --------------------------------------------------------

--
-- Structure de la table `ip_email_templates`
--

CREATE TABLE IF NOT EXISTS `ip_email_templates` (
  `email_template_id` int(11) NOT NULL AUTO_INCREMENT,
  `email_template_title` varchar(255) NOT NULL,
  `email_template_id_prop` int(11) NOT NULL,
  `email_template_type` varchar(255) DEFAULT NULL,
  `email_template_body` longtext NOT NULL,
  `email_template_subject` varchar(255) DEFAULT NULL,
  `email_template_from_name` varchar(255) DEFAULT NULL,
  `email_template_from_email` varchar(255) DEFAULT NULL,
  `email_template_cc` varchar(255) DEFAULT NULL,
  `email_template_bcc` varchar(255) DEFAULT NULL,
  `email_template_pdf_template` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`email_template_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_families`
--

CREATE TABLE IF NOT EXISTS `ip_families` (
  `family_id` int(11) NOT NULL AUTO_INCREMENT,
  `family_name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`family_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `ip_families`
--

INSERT INTO `ip_families` (`family_id`, `family_name`) VALUES
(0, 'DEFAULT');

-- --------------------------------------------------------

--
-- Structure de la table `ip_fournisseurs`
--

CREATE TABLE IF NOT EXISTS `ip_fournisseurs` (
  `id_fournisseur` int(11) NOT NULL AUTO_INCREMENT,
  `raison_social_fournisseur` varchar(200) NOT NULL,
  `adresse_fournisseur` text,
  `adresse2_fournisseur` text,
  `code_postal_fournisseur` varchar(200) NOT NULL,
  `code_postal2_fournisseur` varchar(200) DEFAULT NULL,
  `ville_fournisseur` varchar(200) NOT NULL,
  `ville2_fournisseur` varchar(200) DEFAULT NULL,
  `pays_fournisseur` varchar(200) NOT NULL,
  `pays2_fournisseur` text,
  `site_web_fournisseur` varchar(200) NOT NULL,
  `mail_fournisseur` varchar(200) NOT NULL,
  `tel_fournisseur` varchar(200) NOT NULL,
  `tel2_fournisseur` varchar(200) DEFAULT NULL,
  `fax_fournisseur` varchar(200) NOT NULL,
  `note_fournisseur` text NOT NULL,
  PRIMARY KEY (`id_fournisseur`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_groupes_users`
--

CREATE TABLE IF NOT EXISTS `ip_groupes_users` (
  `groupes_user_id` int(11) NOT NULL AUTO_INCREMENT,
  `designation` varchar(200) NOT NULL,
  `etat` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`groupes_user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `ip_groupes_users`
--

INSERT INTO `ip_groupes_users` (`groupes_user_id`, `designation`, `etat`) VALUES
(1, 'Administrateur', 1),
(4, 'Commercial', 1);

-- --------------------------------------------------------

--
-- Structure de la table `ip_imports`
--

CREATE TABLE IF NOT EXISTS `ip_imports` (
  `import_id` int(11) NOT NULL AUTO_INCREMENT,
  `import_date` datetime NOT NULL,
  PRIMARY KEY (`import_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_import_details`
--

CREATE TABLE IF NOT EXISTS `ip_import_details` (
  `import_detail_id` int(11) NOT NULL AUTO_INCREMENT,
  `import_id` int(11) NOT NULL,
  `import_lang_key` varchar(35) NOT NULL,
  `import_table_name` varchar(35) NOT NULL,
  `import_record_id` int(11) NOT NULL,
  PRIMARY KEY (`import_detail_id`),
  KEY `import_id` (`import_id`,`import_record_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_invoices`
--

CREATE TABLE IF NOT EXISTS `ip_invoices` (
  `invoice_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `invoice_delai_paiement` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_group_id` int(11) NOT NULL,
  `nature` varchar(300) NOT NULL,
  `invoice_status_id` tinyint(2) NOT NULL DEFAULT '1',
  `is_read_only` tinyint(1) DEFAULT NULL,
  `invoice_password` varchar(90) DEFAULT NULL,
  `invoice_date_created` date NOT NULL,
  `invoice_time_created` time NOT NULL DEFAULT '00:00:00',
  `invoice_date_modified` datetime NOT NULL,
  `user_id_modif` int(11) DEFAULT NULL,
  `invoice_date_due` date NOT NULL,
  `invoice_number` int(100) NOT NULL,
  `invoice_terms` longtext NOT NULL,
  `invoice_url_key` char(32) DEFAULT NULL,
  `payment_method` int(11) NOT NULL DEFAULT '0',
  `creditinvoice_parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`invoice_id`),
  UNIQUE KEY `invoice_url_key` (`invoice_url_key`),
  KEY `user_id` (`user_id`,`client_id`,`invoice_group_id`,`invoice_date_created`,`invoice_date_due`,`invoice_number`),
  KEY `invoice_status_id` (`invoice_status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_invoices_recurring`
--

CREATE TABLE IF NOT EXISTS `ip_invoices_recurring` (
  `invoice_recurring_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `recur_start_date` date NOT NULL,
  `recur_end_date` date NOT NULL,
  `recur_frequency` char(2) NOT NULL,
  `recur_next_date` date NOT NULL,
  PRIMARY KEY (`invoice_recurring_id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_invoice_amounts`
--

CREATE TABLE IF NOT EXISTS `ip_invoice_amounts` (
  `invoice_amount_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `invoice_sign` enum('1','-1') NOT NULL DEFAULT '1',
  `invoice_item_subtotal` decimal(20,3) DEFAULT NULL,
  `invoice_item_tax_total` decimal(20,3) DEFAULT NULL,
  `invoice_tax_total` decimal(20,3) NOT NULL DEFAULT '0.000',
  `timbre_fiscale` decimal(20,3) DEFAULT NULL,
  `invoice_total` decimal(20,3) DEFAULT NULL,
  `invoice_paid` decimal(20,3) DEFAULT NULL,
  `invoice_balance` decimal(20,3) DEFAULT NULL,
  `invoice_pourcent_remise` decimal(20,2) DEFAULT NULL,
  `invoice_montant_remise` decimal(20,3) DEFAULT NULL,
  `invoice_pourcent_acompte` decimal(20,2) DEFAULT NULL,
  `invoice_montant_acompte` decimal(20,3) DEFAULT NULL,
  `invoice_item_subtotal_final` decimal(20,3) DEFAULT NULL,
  `invoice_item_tax_total_final` decimal(20,3) DEFAULT NULL,
  PRIMARY KEY (`invoice_amount_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `invoice_paid` (`invoice_paid`,`invoice_balance`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_invoice_custom`
--

CREATE TABLE IF NOT EXISTS `ip_invoice_custom` (
  `invoice_custom_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  PRIMARY KEY (`invoice_custom_id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_invoice_groups`
--

CREATE TABLE IF NOT EXISTS `ip_invoice_groups` (
  `invoice_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_group_name` varchar(50) NOT NULL DEFAULT '',
  `invoice_group_identifier_format` varchar(255) NOT NULL,
  `invoice_group_next_id` int(11) NOT NULL,
  `invoice_group_left_pad` int(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`invoice_group_id`),
  KEY `invoice_group_next_id` (`invoice_group_next_id`),
  KEY `invoice_group_left_pad` (`invoice_group_left_pad`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `ip_invoice_groups`
--

INSERT INTO `ip_invoice_groups` (`invoice_group_id`, `invoice_group_name`, `invoice_group_identifier_format`, `invoice_group_next_id`, `invoice_group_left_pad`) VALUES
(3, 'Invoice Default', '{{{id}}}', 41, 0),
(4, 'Quote Default', 'QUO{{{id}}}', 7, 0);

-- --------------------------------------------------------

--
-- Structure de la table `ip_invoice_items`
--

CREATE TABLE IF NOT EXISTS `ip_invoice_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `family_id` int(11) NOT NULL,
  `item_tax_rate_id` int(11) NOT NULL DEFAULT '0',
  `item_date_added` date NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_description` longtext NOT NULL,
  `item_quantity` decimal(10,2) NOT NULL,
  `item_price` decimal(20,3) NOT NULL,
  `item_order` int(2) NOT NULL DEFAULT '0',
  `item_code` varchar(100) DEFAULT NULL,
  `etat_champ` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `invoice_id` (`invoice_id`,`item_tax_rate_id`,`item_date_added`,`item_order`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_invoice_item_amounts`
--

CREATE TABLE IF NOT EXISTS `ip_invoice_item_amounts` (
  `item_amount_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `item_subtotal` decimal(20,3) NOT NULL,
  `item_tax_total` decimal(20,3) NOT NULL,
  `item_total` decimal(20,3) NOT NULL,
  PRIMARY KEY (`item_amount_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_invoice_tax_rates`
--

CREATE TABLE IF NOT EXISTS `ip_invoice_tax_rates` (
  `invoice_tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `tax_rate_id` int(11) NOT NULL,
  `include_item_tax` int(1) NOT NULL DEFAULT '0',
  `invoice_tax_rate_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`invoice_tax_rate_id`),
  KEY `invoice_id` (`invoice_id`,`tax_rate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_item_lookups`
--

CREATE TABLE IF NOT EXISTS `ip_item_lookups` (
  `item_lookup_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(100) NOT NULL DEFAULT '',
  `item_description` longtext NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`item_lookup_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_merchant_responses`
--

CREATE TABLE IF NOT EXISTS `ip_merchant_responses` (
  `merchant_response_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `merchant_response_date` date NOT NULL,
  `merchant_response_driver` varchar(35) NOT NULL,
  `merchant_response` varchar(255) NOT NULL,
  `merchant_response_reference` varchar(255) NOT NULL,
  PRIMARY KEY (`merchant_response_id`),
  KEY `merchant_response_date` (`merchant_response_date`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_paiement_invoices`
--

CREATE TABLE IF NOT EXISTS `ip_paiement_invoices` (
  `id_paiement_invoice` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL,
  `paiment_amount` float(10,3) NOT NULL,
  `paiement_id` int(11) NOT NULL,
  PRIMARY KEY (`id_paiement_invoice`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_payments`
--

CREATE TABLE IF NOT EXISTS `ip_payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `client_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_method_id` int(11) NOT NULL DEFAULT '0',
  `payment_date` date NOT NULL,
  `payment_amount` decimal(10,3) NOT NULL,
  `payment_ref` varchar(100) DEFAULT NULL,
  `payment_dat_eche` date DEFAULT NULL,
  `payment_note` longtext,
  `acc` int(1) DEFAULT NULL,
  PRIMARY KEY (`payment_id`),
  KEY `invoice_id` (`invoice_id`),
  KEY `payment_method_id` (`payment_method_id`),
  KEY `payment_amount` (`payment_amount`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_payment_custom`
--

CREATE TABLE IF NOT EXISTS `ip_payment_custom` (
  `payment_custom_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  PRIMARY KEY (`payment_custom_id`),
  KEY `payment_id` (`payment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_payment_methods`
--

CREATE TABLE IF NOT EXISTS `ip_payment_methods` (
  `payment_method_id` int(11) NOT NULL AUTO_INCREMENT,
  `payment_method_name` varchar(35) NOT NULL,
  PRIMARY KEY (`payment_method_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `ip_payment_methods`
--

INSERT INTO `ip_payment_methods` (`payment_method_id`, `payment_method_name`) VALUES
(1, 'Chèque'),
(2, 'Carte bancaire'),
(3, 'Espèces'),
(4, 'Virement');

-- --------------------------------------------------------

--
-- Structure de la table `ip_pieces`
--

CREATE TABLE IF NOT EXISTS `ip_pieces` (
  `id_piece` int(11) NOT NULL AUTO_INCREMENT,
  `payment_id` int(11) NOT NULL,
  `num_piece` varchar(50) NOT NULL,
  `montant` decimal(20,0) DEFAULT NULL,
  `echeance` date DEFAULT NULL,
  `proprietaire` varchar(100) NOT NULL,
  `banque` varchar(100) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id_piece`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_prix_ventes`
--

CREATE TABLE IF NOT EXISTS `ip_prix_ventes` (
  `id_prix_ventes` int(11) NOT NULL AUTO_INCREMENT,
  `id_products` int(11) NOT NULL,
  `prix_vente` decimal(20,3) NOT NULL,
  `id_devise` int(11) NOT NULL,
  `id_tax` int(11) NOT NULL,
  `etat` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_prix_ventes`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_products`
--

CREATE TABLE IF NOT EXISTS `ip_products` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `family_id` int(11) NOT NULL,
  `product_sku` varchar(15) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_description` longtext NOT NULL,
  `product_price` float(10,2) NOT NULL,
  `purchase_price` float(10,2) NOT NULL,
  `tax_rate_id` int(11) NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_quotes`
--

CREATE TABLE IF NOT EXISTS `ip_quotes` (
  `quote_id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `invoice_group_id` int(11) NOT NULL,
  `quote_status_id` tinyint(2) NOT NULL DEFAULT '1',
  `quote_date_created` date NOT NULL,
  `quote_date_modified` datetime NOT NULL,
  `quote_user_modif` int(11) DEFAULT NULL,
  `quote_date_expires` date NOT NULL,
  `quote_number` varchar(100) NOT NULL,
  `quote_url_key` char(32) NOT NULL,
  `quote_password` varchar(90) DEFAULT NULL,
  `notes` longtext,
  `quote_nature` varchar(100) NOT NULL,
  `quote_delai_paiement` int(11) NOT NULL,
  `quote_date_accepte` date DEFAULT NULL,
  `delete` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`quote_id`),
  KEY `user_id` (`user_id`,`client_id`,`invoice_group_id`,`quote_date_created`,`quote_date_expires`,`quote_number`),
  KEY `invoice_id` (`invoice_id`),
  KEY `quote_status_id` (`quote_status_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_quote_amounts`
--

CREATE TABLE IF NOT EXISTS `ip_quote_amounts` (
  `quote_amount_id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  `quote_item_subtotal` decimal(20,3) DEFAULT NULL,
  `quote_item_tax_total` decimal(20,3) DEFAULT NULL,
  `quote_tax_total` decimal(20,3) DEFAULT NULL,
  `timbre_fiscale` decimal(20,3) DEFAULT NULL,
  `quote_total` decimal(20,3) DEFAULT NULL,
  `quote_pourcent_remise` decimal(20,2) DEFAULT NULL,
  `quote_montant_remise` decimal(20,3) DEFAULT NULL,
  `quote_pourcent_acompte` decimal(20,2) DEFAULT NULL,
  `quote_montant_acompte` decimal(20,3) DEFAULT NULL,
  `quote_item_subtotal_final` decimal(20,3) DEFAULT NULL,
  `quote_item_tax_total_final` decimal(20,3) DEFAULT NULL,
  `quote_total_final` decimal(20,3) DEFAULT NULL,
  `quote_total_a_payer` decimal(20,3) DEFAULT NULL,
  PRIMARY KEY (`quote_amount_id`),
  KEY `quote_id` (`quote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_quote_custom`
--

CREATE TABLE IF NOT EXISTS `ip_quote_custom` (
  `quote_custom_id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  PRIMARY KEY (`quote_custom_id`),
  KEY `quote_id` (`quote_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_quote_date_rappel`
--

CREATE TABLE IF NOT EXISTS `ip_quote_date_rappel` (
  `rappel_id` int(11) NOT NULL AUTO_INCREMENT,
  `rappel_qote_id` int(11) NOT NULL,
  `rappel_date` date NOT NULL,
  `rappel_status` int(11) NOT NULL,
  `rappel_type` varchar(50) NOT NULL,
  PRIMARY KEY (`rappel_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_quote_items`
--

CREATE TABLE IF NOT EXISTS `ip_quote_items` (
  `item_id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  `item_tax_rate_id` int(11) NOT NULL,
  `item_date_added` date NOT NULL,
  `item_code` varchar(100) NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_description` longtext NOT NULL,
  `item_quantity` decimal(10,2) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `family_id` int(11) NOT NULL,
  `item_order` int(2) NOT NULL DEFAULT '0',
  `etat_champ` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  KEY `quote_id` (`quote_id`,`item_date_added`,`item_order`),
  KEY `item_tax_rate_id` (`item_tax_rate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_quote_item_amounts`
--

CREATE TABLE IF NOT EXISTS `ip_quote_item_amounts` (
  `item_amount_id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `item_subtotal` decimal(10,2) NOT NULL DEFAULT '0.00',
  `item_tax_total` decimal(10,2) NOT NULL,
  `item_total` decimal(10,2) NOT NULL,
  PRIMARY KEY (`item_amount_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_quote_tax_rates`
--

CREATE TABLE IF NOT EXISTS `ip_quote_tax_rates` (
  `quote_tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `quote_id` int(11) NOT NULL,
  `tax_rate_id` int(11) NOT NULL,
  `include_item_tax` int(1) NOT NULL DEFAULT '0',
  `quote_tax_rate_amount` decimal(10,2) NOT NULL,
  PRIMARY KEY (`quote_tax_rate_id`),
  KEY `quote_id` (`quote_id`),
  KEY `tax_rate_id` (`tax_rate_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_settings`
--

CREATE TABLE IF NOT EXISTS `ip_settings` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(50) NOT NULL,
  `setting_value` longtext NOT NULL,
  PRIMARY KEY (`setting_id`),
  KEY `setting_key` (`setting_key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=87 ;

--
-- Contenu de la table `ip_settings`
--

INSERT INTO `ip_settings` (`setting_id`, `setting_key`, `setting_value`) VALUES
(19, 'default_language', 'French'),
(20, 'date_format', 'd/m/Y'),
(21, 'currency_symbol', ' DT'),
(22, 'currency_symbol_placement', 'after'),
(23, 'invoices_due_after', '30'),
(24, 'quotes_expire_after', '15'),
(25, 'default_invoice_group', ''),
(26, 'default_quote_group', ''),
(27, 'thousands_separator', ' '),
(28, 'decimal_point', '.'),
(29, 'cron_key', ''),
(30, 'tax_rate_decimal_places', '3'),
(31, 'pdf_invoice_template', 'default'),
(32, 'pdf_invoice_template_paid', 'default'),
(33, 'pdf_invoice_template_overdue', 'default'),
(34, 'pdf_quote_template', 'default'),
(35, 'public_invoice_template', 'default'),
(36, 'public_quote_template', 'default'),
(37, 'disable_sidebar', '1'),
(38, 'read_only_toggle', 'paid'),
(39, 'invoice_pre_password', ''),
(40, 'quote_pre_password', ''),
(41, 'first_day_of_week', '0'),
(42, 'default_country', 'TN'),
(43, 'default_list_limit', '15'),
(44, 'quote_overview_period', 'this-month'),
(45, 'invoice_overview_period', 'this-month'),
(46, 'disable_quickactions', '0'),
(47, 'custom_title', ''),
(48, 'monospace_amounts', '0'),
(49, 'default_invoice_terms', ''),
(50, 'automatic_email_on_recur', '0'),
(51, 'mark_invoices_sent_pdf', '0'),
(52, 'email_invoice_template', ''),
(53, 'email_invoice_template_paid', ''),
(54, 'email_invoice_template_overdue', ''),
(55, 'pdf_invoice_footer', ''),
(56, 'mark_quotes_sent_pdf', '1'),
(57, 'email_quote_template', ''),
(58, 'default_invoice_tax_rate', ''),
(59, 'default_include_item_tax', ''),
(60, 'default_item_tax_rate', '1'),
(61, 'email_send_method', 'phpmail'),
(62, 'smtp_server_address', ''),
(63, 'smtp_authentication', '0'),
(64, 'smtp_username', 'admin'),
(65, 'smtp_port', ''),
(66, 'smtp_security', ''),
(67, 'merchant_enabled', '0'),
(68, 'merchant_driver', ''),
(69, 'merchant_test_mode', '0'),
(70, 'merchant_username', ''),
(71, 'merchant_signature', ''),
(72, 'merchant_currency_code', ''),
(73, 'online_payment_method', ''),
(77, 'default_devis_code', '1000'),
(75, 'default_item_timbre', '0.500'),
(76, 'invoice_logo', ''),
(79, 'smtp_password', ''),
(83, 'mail_admin', ''),
(85, 'next_code_invoice', '1'),
(86, 'next_code_devis', '1');

-- --------------------------------------------------------

--
-- Structure de la table `ip_societes`
--

CREATE TABLE IF NOT EXISTS `ip_societes` (
  `id_societes` int(11) NOT NULL AUTO_INCREMENT,
  `raison_social_societes` varchar(200) NOT NULL,
  `code_tva_societes` varchar(200) NOT NULL,
  `tax_code` varchar(200) NOT NULL,
  `site_web_societes` varchar(200) NOT NULL,
  `mail_societes` varchar(200) NOT NULL,
  `fax_societes` varchar(200) NOT NULL,
  `note_societes` text NOT NULL,
  PRIMARY KEY (`id_societes`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_societe_adresse`
--

CREATE TABLE IF NOT EXISTS `ip_societe_adresse` (
  `id_societe_adresse` int(11) NOT NULL AUTO_INCREMENT,
  `id_societe` int(11) NOT NULL,
  `adresse` text NOT NULL,
  `code_postal` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `pays` varchar(255) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  PRIMARY KEY (`id_societe_adresse`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_tax_rates`
--

CREATE TABLE IF NOT EXISTS `ip_tax_rates` (
  `tax_rate_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_rate_name` varchar(60) NOT NULL,
  `tax_rate_percent` decimal(5,2) NOT NULL,
  PRIMARY KEY (`tax_rate_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `ip_tax_rates`
--

INSERT INTO `ip_tax_rates` (`tax_rate_id`, `tax_rate_name`, `tax_rate_percent`) VALUES
(1, '0', '0.00'),
(2, '12', '12.00'),
(2, '18', '18.00');

-- --------------------------------------------------------

--
-- Structure de la table `ip_users`
--

CREATE TABLE IF NOT EXISTS `ip_users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `groupes_user_id` int(11) NOT NULL,
  `user_type` int(1) NOT NULL DEFAULT '1',
  `user_active` tinyint(1) DEFAULT '1',
  `user_date_created` datetime NOT NULL,
  `user_date_modified` datetime NOT NULL,
  `user_name` varchar(100) DEFAULT '',
  `user_code` varchar(10) DEFAULT NULL,
  `user_company` varchar(100) DEFAULT '',
  `user_address_1` varchar(100) DEFAULT '',
  `user_address_2` varchar(100) DEFAULT '',
  `user_city` varchar(45) DEFAULT '',
  `user_state` varchar(35) DEFAULT '',
  `user_zip` varchar(15) DEFAULT '',
  `user_country` varchar(35) DEFAULT '',
  `user_phone` varchar(20) DEFAULT '',
  `user_fax` varchar(20) DEFAULT '',
  `user_mobile` varchar(20) DEFAULT '',
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(60) NOT NULL,
  `user_web` varchar(100) DEFAULT '',
  `user_vat_id` varchar(100) NOT NULL DEFAULT '',
  `user_tax_code` varchar(100) NOT NULL DEFAULT '',
  `user_psalt` char(22) NOT NULL,
  `user_passwordreset_token` varchar(100) DEFAULT '',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

--
-- Structure de la table `ip_user_clients`
--

CREATE TABLE IF NOT EXISTS `ip_user_clients` (
  `user_client_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  PRIMARY KEY (`user_client_id`),
  KEY `user_id` (`user_id`,`client_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `ip_user_custom`
--

CREATE TABLE IF NOT EXISTS `ip_user_custom` (
  `user_custom_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`user_custom_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Contenu de la table `ip_user_custom`
--

INSERT INTO `ip_user_custom` (`user_custom_id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `ip_versions`
--

CREATE TABLE IF NOT EXISTS `ip_versions` (
  `version_id` int(11) NOT NULL AUTO_INCREMENT,
  `version_date_applied` varchar(14) NOT NULL,
  `version_file` varchar(45) NOT NULL,
  `version_sql_errors` int(2) NOT NULL,
  PRIMARY KEY (`version_id`),
  KEY `version_date_applied` (`version_date_applied`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `ip_versions`
--

INSERT INTO `ip_versions` (`version_id`, `version_date_applied`, `version_file`, `version_sql_errors`) VALUES
(1, '1429109997', '000_1.0.0.sql', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
