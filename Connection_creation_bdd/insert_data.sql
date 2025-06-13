USE `bdd_gsb_`;

-- Insertion table `datecloture`
INSERT INTO `datecloture` (`date_cloture_id`, `libelle_dates`) VALUES
(1, '2025-01-31'), (2, '2025-02-28'), (3, '2025-03-31'), (4, '2025-04-30'),
(5, '2025-05-31'), (6, '2025-06-30'), (7, '2025-07-31'), (8, '2025-08-31'),
(9, '2025-09-30'), (10, '2025-10-31'), (11, '2025-11-30'), (12, '2025-12-31');

-- Insertion table `etatfrais`
INSERT INTO `etatfrais` (`id_Etat_frais`, `Etat`) VALUES
(1, 'Validee'), (2, 'Enattente'), (3, 'Refusee');

-- Insertion table `fiche_frais`
INSERT INTO `fiche_frais` (`id_FicheFrais`, `nbJustificatifs`, `montantValide`, `dateModif`, `idVisiteur`) VALUES
(1, 1, '2465.00', '2025-06-06 11:10:53', 11);

-- Insertion table `ligne_frais`
INSERT INTO `ligne_frais` (`IdFrais`, `TypeFrais`, `Montant`, `Date`, `Justificatif`, `utilisateur_id`, `Etat_Frais_id`, `commentaire`) VALUES
(31, 2, 100, '2025-01-10', '', 11, 1, ''),
(32, 3, 1200, '2025-01-10', 'papier.pdf', 11, 2, ''),
(33, 1, 123, '2025-01-10', NULL, 11, 1, ''),
(34, 2, 12, '2025-01-10', NULL, 11, 3, 'ss'),
(35, 1, 300, '2025-01-15', NULL, 11, 1, ''),
(38, 3, 130, '2025-01-18', NULL, 10, 1, ''),
(39, 2, 1200, '2025-03-27', NULL, 11, 1, ''),
(40, 1, 200, '2025-01-23', NULL, 11, 1, ''),
(41, 4, 400, '2025-01-26', NULL, 11, 1, '');

-- Insertion table `roles`
INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'admin'), (2, 'comptable'), (3, 'visiteur');

-- Insertion table `typefrais`
INSERT INTO `typefrais` (`Libelle_id`, `libelle`) VALUES
(1, 'nuitees'), (2, 'kilometrage'), (3, 'repas'), (4, 'Autre');

-- Insertion table `utilisateurs`
INSERT INTO `utilisateurs` (`IdVisiteur`, `Nom`, `Matricule`, `Prenom`, `Ville`, `Mail`, `Mot_de_passe`, `role_id`) VALUES
(3, 'user1', '0000-00-00', 'ser1', 'Lyon', 'user1@example.com', 'hashedpassword1', 3),
(4, 'user2', '0000-00-00', 'ser2', 'Bron', 'user2@example.com', 'hashedpassword2', 3),
(5, 'user3', '0000-00-00', 'ser3', 'Miribel', 'user3@example.com', 'hashedpassword3', 1),
(7, 'nicolas', '0000-00-00', 'LEGRAND', 'Lyon 2', 'nico@gmail.com', '$2y$10$MP13xHTK18i0T7X.JV2oyu0.54hlKJSxb2KBgKL0ui6NW5rBmDq.a', 3),
(8, 'max', '0000-00-00', 'chanel', 'Rillieux', 'maxime@gmail.com', '$2y$10$IgatyRf75ZZ0gbPnV9IqReobrKtenj.UW.B0LfhJx6evo7Mc9acre', 1),
(9, 'azert', '0000-00-00', 'boulot', 'Grenoble', 'azert@gmail.com', '$2y$10$ncncMZBBvv1ItmqWnPFjRu5VktAiJ26WPAPMMeFwE6R6F9gLmv8O6', 1),
(10, 'mathieu', 'TFYTGUY', 'lepetit', 'bron', 'mathieu@gmail.com', '$2y$10$GygBOlCfrHtX9bWbv.91tuimHukr.sBP.nanLALp5TOqiG9WhrCrG', 2),
(11, 'Duchamp', 'ACZET', 'Paul', 'Miribel', 'paul.duchamp@gmail.com', '$2y$10$a7qgc05w4xukWxbeohv3/.nYUC43wkO.4vu.KzU.Sr42fSb/ki3aK', 3),
(12, 'Madere', 'AZERTY', 'Hugo', 'Villefranche', 'hugo@gmail.com', '$2y$10$N.pFKCbKJCp8JSY7ADJi3uRVYXB0CCVmBA21PIorhvVJ9pNLJ7x5O', 3),
(13, 'eace', 'dsaecaec', 'acezac', 'aeceaca', 'khal@gmail.com', '$2y$10$aI.osMorJPE93QTDNA8bXeOreCgeR5fqULgW4ZAa/WloP2vAIh0VW', 3),
(14, 'DELARUE', 'MFJGJ', 'Christian', 'Neuville', 'christian@gmail.com', '$2y$10$9i/kl1HePOjFgmQnVq/9SOVwVOUIum2vAx8J.qVIC6iHF6VMiL29e', 3);
