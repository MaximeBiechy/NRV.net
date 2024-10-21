-- Connexion à la base de données nrv_auth
\connect
nrv_auth;

-- Insertion des utilisateurs
INSERT INTO public.users (id, email, password, role)
VALUES (gen_random_uuid(), 'greg@gmail.com', '$2y$10$Z/Ly0lfKRG8/6.I7Ask8cumJwbmaHPpnTTevulJwerlaK4109okAS', 0),
       (gen_random_uuid(), 'admin@gmail.com', '$2y$10$yEKWI4iJHlN5.PdKp8LvFefnKpclftKoWleY4xFkLHO7NzUUA5RlK', 10),
       (gen_random_uuid(), 'superadmin@gmail.com', '$2y$10$WLGsGcxTevxNT3SWaWYK7.1P34A6FsjWyJkf/qKJz1ry5S/7FYqRS', 100);

-- Connexion à la base de données nrv_party
\connect
nrv_party;

-- Insertion des fêtes (party)
INSERT INTO public.party (id, name, theme, date, begin, place_id, show1_id, show2_id, show3_id)
VALUES (gen_random_uuid(), 'Birthday Bash', 'Anniversaire', '2024-12-25 20:00:00', '2024-12-25 21:00:00',
        gen_random_uuid(), gen_random_uuid(), gen_random_uuid(), NULL),
       (gen_random_uuid(), 'Music Fiesta', 'Musique', '2024-11-01 18:00:00', '2024-11-01 19:00:00', gen_random_uuid(),
        gen_random_uuid(), NULL, NULL);

-- Connexion à la base de données nrv_place
\connect
nrv_place;

-- Insertion des images de lieux
INSERT INTO public.images (id, path, place_id)
VALUES (gen_random_uuid(), '/images/place1.jpg', gen_random_uuid()),
       (gen_random_uuid(), '/images/place2.jpg', gen_random_uuid());

-- Insertion des lieux
INSERT INTO public.places (id, name, address, nbSit, nbStand)
VALUES (gen_random_uuid(), 'Stade de France', 'Saint-Denis, France', 80000, 20000),
       (gen_random_uuid(), 'Zénith Paris', 'Paris, France', 6000, 3000);

-- Connexion à la base de données nrv_show
\connect
nrv_show;

-- Insertion des artistes principalement français
INSERT INTO public.artists (id, name, style)
VALUES (gen_random_uuid(), 'Daft Punk', 'Electro'),
       (gen_random_uuid(), 'Christine and the Queens', 'Pop'),
       (gen_random_uuid(), 'Phoenix', 'Rock'),
       (gen_random_uuid(), 'David Guetta', 'House'),
       (gen_random_uuid(), 'M83', 'Synthpop'),
       (gen_random_uuid(), 'Air', 'Downtempo'),
       (gen_random_uuid(), 'Yann Tiersen', 'Classical'),
       (gen_random_uuid(), 'Zaz', 'Chanson'),
       (gen_random_uuid(), 'Stromae', 'Hip Hop'),
       (gen_random_uuid(), 'Angèle', 'Pop'),
       (gen_random_uuid(), 'Justice', 'Electro'),
       (gen_random_uuid(), 'Sofiane Pamart', 'Piano'),
       (gen_random_uuid(), 'Imany', 'Soul'),
       (gen_random_uuid(), 'Shaka Ponk', 'Rock'),
       (gen_random_uuid(), 'Clara Luciani', 'Chanson'),
       (gen_random_uuid(), 'Julien Doré', 'Pop'),
       (gen_random_uuid(), 'Jeanne Added', 'Indie Rock'),
       (gen_random_uuid(), 'Louane', 'Pop'),
       (gen_random_uuid(), 'Vianney', 'Chanson'),
       (gen_random_uuid(), 'Benjamin Biolay', 'Chanson'),
       (gen_random_uuid(), 'Patrick Bruel', 'Chanson'),
       (gen_random_uuid(), 'Indochine', 'Rock'),
       (gen_random_uuid(), 'Alain Souchon', 'Chanson'),
       (gen_random_uuid(), 'Édith Piaf', 'Chanson'),
       (gen_random_uuid(), 'Serge Gainsbourg', 'Chanson'),
       (gen_random_uuid(), 'Manu Chao', 'World Music'),
       (gen_random_uuid(), 'Gojira', 'Metal'),
       (gen_random_uuid(), 'Camille', 'Experimental'),
       (gen_random_uuid(), 'Aya Nakamura', 'R&B'),
       (gen_random_uuid(), 'Booba', 'Rap'),
       (gen_random_uuid(), 'PNL', 'Rap'),
       (gen_random_uuid(), 'Soprano', 'Rap'),
       (gen_random_uuid(), 'Maître Gims', 'Pop'),
       (gen_random_uuid(), 'MC Solaar', 'Rap'),
       (gen_random_uuid(), 'Kendji Girac', 'Pop'),
       (gen_random_uuid(), 'Black M', 'Rap'),
       (gen_random_uuid(), 'Bigflo & Oli', 'Rap'),
       (gen_random_uuid(), 'Lou Doillon', 'Indie'),
       (gen_random_uuid(), 'Brigitte', 'Pop'),
       (gen_random_uuid(), 'Jain', 'Pop'),
       (gen_random_uuid(), 'Izïa', 'Rock'),
       (gen_random_uuid(), 'Rone', 'Electro'),
       (gen_random_uuid(), 'Therapie TAXI', 'Pop'),
       (gen_random_uuid(), 'Kassav', 'Zouk'),
       (gen_random_uuid(), 'Johnny Hallyday', 'Rock'),
       (gen_random_uuid(), 'Charles Aznavour', 'Chanson'),
       (gen_random_uuid(), 'Jacques Brel', 'Chanson'),
       (gen_random_uuid(), 'Francis Cabrel', 'Chanson'),
       (gen_random_uuid(), 'Jul', 'Rap'),
       (gen_random_uuid(), 'Damso', 'Rap'),
       (gen_random_uuid(), 'Lomepal', 'Rap'),
       (gen_random_uuid(), 'Eddy de Pretto', 'Pop'),
       (gen_random_uuid(), 'M', 'Pop'),
       (gen_random_uuid(), 'Claudio Capéo', 'Pop'),
       (gen_random_uuid(), 'Amir', 'Pop'),
       (gen_random_uuid(), 'Suzane', 'Pop'),
       (gen_random_uuid(), 'Yseult', 'Pop'),
       (gen_random_uuid(), 'Zaho', 'R&B'),
       (gen_random_uuid(), 'Hoshi', 'Pop'),
       (gen_random_uuid(), 'Les Rita Mitsouko', 'Rock'),
       (gen_random_uuid(), 'Nekfeu', 'Rap'),
       (gen_random_uuid(), 'Orelsan', 'Rap'),
       (gen_random_uuid(), 'IAM', 'Rap'),
       (gen_random_uuid(), 'NTM', 'Rap'),
       (gen_random_uuid(), 'Tryo', 'Reggae'),
       (gen_random_uuid(), 'Lea Castel', 'Pop'),
       (gen_random_uuid(), 'Shym', 'Pop'),
       (gen_random_uuid(), 'Lara Fabian', 'Pop'),
       (gen_random_uuid(), 'Calogero', 'Pop'),
       (gen_random_uuid(), 'Garou', 'Pop'),
       (gen_random_uuid(), 'Pascal Obispo', 'Pop'),
       (gen_random_uuid(), 'Florent Pagny', 'Pop'),
       (gen_random_uuid(), 'Michel Sardou', 'Chanson'),
       (gen_random_uuid(), 'Mylène Farmer', 'Pop');

-- Insertion des images de spectacles
INSERT INTO public.images (id, path, show_id)
VALUES (gen_random_uuid(), '/images/show1.jpg', gen_random_uuid()),
       (gen_random_uuid(), '/images/show2.jpg', gen_random_uuid());

-- Insertion des spectacles
INSERT INTO public.shows (id, title, description, video, begin)
VALUES (gen_random_uuid(), 'Daft Punk Show', 'Un concert unique avec Daft Punk', '/videos/daftpunk.mp4',
        '2024-12-31 22:00:00'),
       (gen_random_uuid(), 'Phoenix Live', 'Phoenix en live à Paris', '/videos/phoenix.mp4', '2024-11-15 20:00:00');

-- Insertion des performances d'artistes
INSERT INTO public.perform (show_id, artist_id)
VALUES (gen_random_uuid(), gen_random_uuid()),
       (gen_random_uuid(), gen_random_uuid());
