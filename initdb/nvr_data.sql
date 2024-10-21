-- Connexion à la base de données nrv_auth
\connect nrv_auth;

-- Insertion des utilisateurs
INSERT INTO public.users (id, email, password, role)
VALUES (gen_random_uuid(), 'greg@gmail.com', '$2y$10$Z/Ly0lfKRG8/6.I7Ask8cumJwbmaHPpnTTevulJwerlaK4109okAS', 0),
       (gen_random_uuid(), 'admin@gmail.com', '$2y$10$yEKWI4iJHlN5.PdKp8LvFefnKpclftKoWleY4xFkLHO7NzUUA5RlK', 10),
       (gen_random_uuid(), 'superadmin@gmail.com', '$2y$10$WLGsGcxTevxNT3SWaWYK7.1P34A6FsjWyJkf/qKJz1ry5S/7FYqRS', 100);

-- Connexion à la base de données nrv_place
\connect nrv_place;

-- Insertion des images de lieux
INSERT INTO public.images (id, path, place_id)
VALUES (gen_random_uuid(), '/images/place1.jpg', gen_random_uuid()),
       (gen_random_uuid(), '/images/place2.jpg', gen_random_uuid());

-- Insertion des lieux
INSERT INTO public.places (id, name, address, nbSit, nbStand)
VALUES (gen_random_uuid(), 'Stade de France', 'Saint-Denis, France', 80000, 20000),
       (gen_random_uuid(), 'Zénith Paris', 'Paris, France', 6000, 3000);

-- Connexion à la base de données nrv_show
\connect nrv_show;

-- Insertion des styles musicaux
INSERT INTO public.style (id, name)
VALUES (gen_random_uuid(), 'Electro'),
       (gen_random_uuid(), 'Pop'),
       (gen_random_uuid(), 'Rock'),
       (gen_random_uuid(), 'House'),
       (gen_random_uuid(), 'Synthpop'),
       (gen_random_uuid(), 'Downtempo'),
       (gen_random_uuid(), 'Classical'),
       (gen_random_uuid(), 'Chanson'),
       (gen_random_uuid(), 'Hip Hop'),
       (gen_random_uuid(), 'Rap'),
       (gen_random_uuid(), 'R&B'),
       (gen_random_uuid(), 'Metal');


\connect nrv_show;
-- Insertion des artistes avec les valeurs spécifiées
INSERT INTO public.artists (id, name, style, image)
VALUES (gen_random_uuid(), 'Daft Punk', 'Electro', 'default.jpg'),
       (gen_random_uuid(), 'Christine and the Queens', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Phoenix', 'Rock', 'default.jpg'),
       (gen_random_uuid(), 'David Guetta', 'House', 'default.jpg'),
       (gen_random_uuid(), 'M83', 'Synthpop', 'default.jpg'),
       (gen_random_uuid(), 'Air', 'Downtempo', 'default.jpg'),
       (gen_random_uuid(), 'Yann Tiersen', 'Classical', 'default.jpg'),
       (gen_random_uuid(), 'Zaz', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Stromae', 'Hip Hop', 'default.jpg'),
       (gen_random_uuid(), 'Angèle', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Justice', 'Electro', 'default.jpg'),
       (gen_random_uuid(), 'Sofiane Pamart', 'Piano', 'default.jpg'),
       (gen_random_uuid(), 'Imany', 'Soul', 'default.jpg'),
       (gen_random_uuid(), 'Shaka Ponk', 'Rock', 'default.jpg'),
       (gen_random_uuid(), 'Clara Luciani', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Julien Doré', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Jeanne Added', 'Indie Rock', 'default.jpg'),
       (gen_random_uuid(), 'Louane', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Vianney', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Benjamin Biolay', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Patrick Bruel', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Indochine', 'Rock', 'default.jpg'),
       (gen_random_uuid(), 'Alain Souchon', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Édith Piaf', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Serge Gainsbourg', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Manu Chao', 'World Music', 'default.jpg'),
       (gen_random_uuid(), 'Gojira', 'Metal', 'default.jpg'),
       (gen_random_uuid(), 'Camille', 'Experimental', 'default.jpg'),
       (gen_random_uuid(), 'Aya Nakamura', 'R&B', 'default.jpg'),
       (gen_random_uuid(), 'Booba', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'PNL', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'Soprano', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'Maître Gims', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'MC Solaar', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'Kendji Girac', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Black M', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'Bigflo & Oli', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'Lou Doillon', 'Indie', 'default.jpg'),
       (gen_random_uuid(), 'Brigitte', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Jain', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Izïa', 'Rock', 'default.jpg'),
       (gen_random_uuid(), 'Rone', 'Electro', 'default.jpg'),
       (gen_random_uuid(), 'Therapie TAXI', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Kassav', 'Zouk', 'default.jpg'),
       (gen_random_uuid(), 'Johnny Hallyday', 'Rock', 'default.jpg'),
       (gen_random_uuid(), 'Charles Aznavour', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Jacques Brel', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Francis Cabrel', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Jul', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'Damso', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'Lomepal', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'Eddy de Pretto', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'M', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Claudio Capéo', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Amir', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Suzane', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Yseult', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Zaho', 'R&B', 'default.jpg'),
       (gen_random_uuid(), 'Hoshi', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Les Rita Mitsouko', 'Rock', 'default.jpg'),
       (gen_random_uuid(), 'Nekfeu', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'Orelsan', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'IAM', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'NTM', 'Rap', 'default.jpg'),
       (gen_random_uuid(), 'Tryo', 'Reggae', 'default.jpg'),
       (gen_random_uuid(), 'Lea Castel', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Shym', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Lara Fabian', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Calogero', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Garou', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Pascal Obispo', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Florent Pagny', 'Pop', 'default.jpg'),
       (gen_random_uuid(), 'Michel Sardou', 'Chanson', 'default.jpg'),
       (gen_random_uuid(), 'Mylène Farmer', 'Pop', 'default.jpg');


-- Insertion des correspondances artistes et styles dans la table artists2style
INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Daft Punk'), (SELECT id FROM public.style WHERE name = 'Electro');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Christine and the Queens'),
       (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Phoenix'), (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'David Guetta'), (SELECT id FROM public.style WHERE name = 'House');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'M83'), (SELECT id FROM public.style WHERE name = 'Synthpop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Air'), (SELECT id FROM public.style WHERE name = 'Downtempo');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Yann Tiersen'),
       (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Zaz'), (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Stromae'), (SELECT id FROM public.style WHERE name = 'Hip Hop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Angèle'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Justice'), (SELECT id FROM public.style WHERE name = 'Electro');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Sofiane Pamart'),
       (SELECT id FROM public.style WHERE name = 'Piano');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Imany'), (SELECT id FROM public.style WHERE name = 'Soul');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Shaka Ponk'), (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Clara Luciani'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Julien Doré'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Jeanne Added'),
       (SELECT id FROM public.style WHERE name = 'Indie Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Louane'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Vianney'), (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Benjamin Biolay'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Patrick Bruel'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Indochine'), (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Alain Souchon'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Édith Piaf'), (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Serge Gainsbourg'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Manu Chao'),
       (SELECT id FROM public.style WHERE name = 'World Music');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Gojira'), (SELECT id FROM public.style WHERE name = 'Metal');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Camille'),
       (SELECT id FROM public.style WHERE name = 'Experimental');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Aya Nakamura'), (SELECT id FROM public.style WHERE name = 'R&B');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Booba'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'PNL'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Soprano'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Maître Gims'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'MC Solaar'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Kendji Girac'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Black M'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Bigflo & Oli'), (SELECT id FROM public.style WHERE name = 'Rap');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Lou Doillon'), (SELECT id FROM public.style WHERE name = 'Indie');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Brigitte'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Jain'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Izïa'), (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Rone'), (SELECT id FROM public.style WHERE name = 'Electro');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Therapie TAXI'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Kassav'), (SELECT id FROM public.style WHERE name = 'Zouk');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Johnny Hallyday'),
       (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Charles Aznavour'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Mylène Farmer'), (SELECT id FROM public.style WHERE name = 'Pop');


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
VALUES (gen_random_uuid(), gen_random_uuid()), -- Artiste 1 dans Show 1
       (gen_random_uuid(), gen_random_uuid()); -- Artiste 2 dans Show 2
