-- DATA FOR AUTH
\connect
nrv_auth;
-- Insertion des utilisateurs
INSERT INTO public.users (id, email, password, role)
VALUES ('669d5162-84b0-4edc-b043-3ccfa71eb0a9', 'greg@gmail.com',
        '$2y$10$Z/Ly0lfKRG8/6.I7Ask8cumJwbmaHPpnTTevulJwerlaK4109okAS', 0),
       ('2a0d23e7-dab5-4074-be44-4a2822d92915', 'admin@gmail.com',
        '$2y$10$yEKWI4iJHlN5.PdKp8LvFefnKpclftKoWleY4xFkLHO7NzUUA5RlK', 10),
       ('23daaea8-68d2-4d80-90cf-0d01339c92d7', 'superadmin@gmail.com',
        '$2y$10$WLGsGcxTevxNT3SWaWYK7.1P34A6FsjWyJkf/qKJz1ry5S/7FYqRS', 100);

-- DATA FOR PLACES
\connect
nrv_place;

INSERT INTO public.places (id, name, address, nb_sit, nb_stand)
VALUES ('340cf1fe-6344-4e93-ab6a-347c7e461d36', 'Stade de France', 'Saint-Denis, France', 80000, 20000),
       ('b6b101d5-563e-4530-a3bb-43be12ea1053', 'Zénith Paris', 'Paris, France', 6000, 3000);

-- Insertion des images de lieux
INSERT INTO public.images (id, path, place_id)
VALUES ('35346ab9-f0c2-4651-a5d5-1be4fcdc346f', '/images/stadedefrance.jpg',
        (SELECT id FROM public.places WHERE name = 'Stade de France')),
       ('8e60916a-6580-4a37-974c-1f10e25ecf12', '/images/zenithparis.jpg',
        (SELECT id FROM public.places WHERE name = 'Zénith Paris'));

-- DATA FOR SHOW
\connect
nrv_show;

-- Insertion des styles musicaux
INSERT INTO public.style (id, name)
VALUES ('93e91764-4650-4dc9-8507-c3f12995329e', 'Electro'),
       ('200996e1-6409-4fbf-b146-d3e03b1d10f5', 'Pop'),
       ('d6fcb401-726e-4fdb-b3fa-081b22d04158', 'Rock'),
       ('39a2dcb7-fe12-40ff-950e-495efb4af12d', 'House'),
       ('9b9f7e69-2226-4248-85d3-8ad0ed4f06dc', 'Synthpop'),
       ('7d0670bd-8b9a-442d-900a-0f2309808e65', 'Downtempo'),
       ('369f8daa-5922-4b67-be56-6cb0c65b943b', 'Classical'),
       ('15b61ab3-1d88-443a-93b5-d82a31aa7699', 'Chanson'),
       ('3379deb3-fcd4-4fe0-9003-aa6880ee6943', 'Hip Hop'),
       ('7ed03ec9-4a9b-43c0-acd0-f8e485d106a1', 'Rap'),
       ('cabc1af4-4110-4587-b216-6caa8834b00d', 'R&B'),
       ('8a7b1292-f7f6-48f0-bbaa-d275f566f498', 'Metal');

-- Insertion des artistes avec les valeurs spécifiées
INSERT INTO public.artists (id, name, style, image)
VALUES ('3fc424d2-b3c7-4bf9-9bd5-0a0d86c40543', 'Daft Punk', 'Electro', 'daftpunk.jpg'),
       ('6abedb09-8f65-424f-be99-8c0e0829db03', 'Christine and the Queens', 'Pop', 'christine.jpg'),
       ('c3dfb3ab-d942-4494-a8c3-eedbf6c9d6a7', 'Phoenix', 'Rock', 'phoenix.jpg'),
       ('5f89da2b-321d-4c58-bfe5-24a7796235d8', 'David Guetta', 'House', 'davidguetta.jpg'),
       ('a8f6597f-473a-4ff6-8508-ed91451faa50', 'M83', 'Synthpop', 'm83.jpg'),
       ('f19b8af0-3f83-4e6c-8400-4d56181a4e96', 'Air', 'Downtempo', 'default.jpg'),
       ('86d47229-0879-41d7-84f4-b247131e48ac', 'Yann Tiersen', 'Classical', 'yanntiersen.jpg'),
       ('6e9e694a-929e-4946-b793-89f61acc153a', 'Zaz', 'Chanson', 'zaz.jpg'),
       ('1dec3475-f06a-4ae1-bce4-336e8f1413e1', 'Stromae', 'Hip Hop', 'stromae.jpg'),
       ('d33bd958-188f-4050-94c9-dd232a4ff2c2', 'Angèle', 'Pop', 'angele.jpg'),
       ('c407a275-6535-4e78-acb5-8ff8ba9885f6', 'Justice', 'Electro', 'justice.jpg'),
       ('732bffd7-697b-4cc3-8574-cca23109b0f8', 'Sofiane Pamart', 'Piano', 'sofianepamart.jpg'),
       ('3180a9a5-dcf4-44aa-b21d-eea6ef8b47b5', 'Imany', 'Soul', 'imany.jpg'),
       ('830ba487-8ab2-4af3-a0fa-97d94b47d7fc', 'Shaka Ponk', 'Rock', 'shakaponk.jpg'),
       ('d1471672-0648-4f65-abb5-ecd59e61efd1', 'Clara Luciani', 'Chanson', 'claraluciani.jpg'),
       ('837efa7b-d907-4149-9821-2c624a9ad140', 'Julien Doré', 'Pop', 'juliendore.jpg'),
       ('8a4a6a1c-6419-447e-9ae4-f6e2c484f423', 'Jeanne Added', 'Indie Rock', 'jeanneadded.jpg'),
       ('1aeb84f9-bd55-4957-b06b-1523dd27d851', 'Louane', 'Pop', 'louane.jpg'),
       ('5cb9efac-6fb4-43ab-a0f8-cb9c0bc9522b', 'Vianney', 'Chanson', 'vianney.jpg'),
       ('5dbfb52d-cc65-48d2-bad3-c11b8fc9e920', 'Benjamin Biolay', 'Chanson', 'benjaminbiolay.jpg'),
       ('3dff74cb-7ae7-44d6-a4e5-44b818c15886', 'Patrick Bruel', 'Chanson', 'patrickbruel.jpg'),
       ('3dff74cb-7ae7-44d6-a4e5-44b818c15886', 'Indochine', 'Rock', 'indochine.jpg'),
       ('8e3921a0-4dda-4021-9251-28739a13063b', 'Alain Souchon', 'Chanson', 'alainsouchon.jpg'),
       ('b4269b6d-3b6a-47ae-9d93-28fa2c0d6fce', 'Édith Piaf', 'Chanson', 'edithpiaf.jpg'),
       ('38d78cad-a7b3-4875-9d9f-054988db45a5', 'Serge Gainsbourg', 'Chanson', 'sergegainsbourg.jpg'),
       ('db2f0967-8b47-4892-8d18-f1d4fc156712', 'Manu Chao', 'World Music', 'manuchao.jpg'),
       ('05c10123-0165-4c52-b943-57eb1935e08d', 'Gojira', 'Metal', 'gojira.jpg'),
       ('9419f77e-db21-4ed1-9e5f-fb04373e2400', 'Camille', 'Experimental', 'default.jpg'),
       ('81a432bc-b9b0-4965-8884-1b8b3ed1f48b', 'Aya Nakamura', 'R&B', 'ayanakamura.jpg'),
       ('f9b357ab-43cc-4838-a91a-2c3359d42031', 'Booba', 'Rap', 'booba.jpg'),
       ('88157f29-a90e-4eab-be23-6195e0c8246b', 'PNL', 'Rap', 'pnl.jpg'),
       ('ec8c796b-4800-4239-b02a-d67958fbcfc3', 'Soprano', 'Rap', 'soprano.jpg'),
       ('2a17f930-c5c1-47b2-baf0-78d9f10eec33', 'Maître Gims', 'Pop', 'maitregims.jpg'),
       ('d76e00c4-61c9-4c41-a854-5e899f645378', 'MC Solaar', 'Rap', 'mcsolaar.jpg'),
       ('93b95145-bc4a-4a98-80c5-16b25111256a', 'Kendji Girac', 'Pop', 'kendjigirac.jpg'),
       ('31a83440-e9ef-4093-b908-f1716413c05e', 'Black M', 'Rap', 'blackm.jpg'),
       ('b64615f4-2ff8-4990-8031-07dd40479c20', 'Bigflo & Oli', 'Rap', 'bigflo&oli.jpg'),
       ('0b008605-0039-4da0-a84e-88d6663d1743', 'Lou Doillon', 'Indie', 'loudoillon.jpg'),
       ('cc1aa06d-4759-48b5-874d-d49817d4a274', 'Brigitte', 'Pop', 'default.jpg'),
       ('9968dcf8-068e-4f2b-9f6c-5453b9a31ee3', 'Jain', 'Pop', 'jain.jpg'),
       ('2d8ee4ff-cd0e-4a7e-a51f-d61dac39bec4', 'Izïa', 'Rock', 'izia.jpg'),
       ('c7df396b-fe96-4988-b875-86063c8727d7', 'Rone', 'Electro', 'rone.jpg'),
       ('58e41536-f262-4294-aec9-949ba6864b60', 'Therapie TAXI', 'Pop', 'therapietaxi.jpg'),
       ('b8797a32-d19d-4fe3-a5c5-5c471e19d993', 'Kassav', 'Zouk', 'kassav.jpg'),
       ('66ccca0a-e14a-4950-b6af-85ef7bcb81a0', 'Johnny Hallyday', 'Rock', 'johnnyhalliday.jpg'),
       ('a550cfa3-9467-4c9f-87fc-940e5414b851', 'Charles Aznavour', 'Chanson', 'charlesaznavour.jpg'),
       ('1d22c608-7f1d-4624-8790-89366dc00b14', 'Jacques Brel', 'Chanson', 'jacquesbrel.jpg'),
       ('c5cfcd88-977f-4c57-95bb-86db5e577906', 'Francis Cabrel', 'Chanson', 'franciscabrel.jpg'),
       ('aa18eb59-95a0-4eb7-9eba-7f651aafa4ce', 'Jul', 'Rap', 'jul.jpg'),
       ('881ed44e-6df0-4b8a-96ef-42b263900643', 'Damso', 'Rap', 'damso.jpg'),
       ('18fc6ea1-1e3d-4556-96ca-db8f7b68d3b4', 'Lomepal', 'Rap', 'lomepal.jpg'),
       ('8933cee2-8c4d-4dff-b111-b2c16a1ab3cd', 'Eddy de Pretto', 'Pop', 'eddydepretto.jpg'),
       ('3df8cb67-1037-4e95-a426-04391f061fe6', 'M', 'Pop', 'm.jpg'),
       ('e402ef41-4c22-4da1-8738-d51e740df156', 'Claudio Capéo', 'Pop', 'claudiocapeo.jpg'),
       ('3f982975-909b-43cd-b71c-bc6c31c4938f', 'Amir', 'Pop', 'amir.jpg'),
       ('d380097d-438a-43b6-ae22-d757847e880e', 'Suzane', 'Pop', 'default.jpg'),
       ('c30f0641-f138-4869-b066-95b123bb9257', 'Yseult', 'Pop', 'yseult.jpg'),
       ('462ef814-d0e8-488f-9731-9ddf6630e2cf', 'Zaho', 'R&B', 'zaho.jpg'),
       ('0d5aa540-6774-400d-a2e4-543cc9514bea', 'Hoshi', 'Pop', 'hoshi.jpg'),
       ('8e66a186-4140-4288-8838-5fae5ad11d3f', 'Les Rita Mitsouko', 'Rock', 'lesritamitsouko.jpg'),
       ('c3952c5d-87b5-4616-a4ad-51c3301ec035', 'Nekfeu', 'Rap', 'nekfeu.jpg'),
       ('2190bfe6-9f75-422a-aa2a-76882001e2f6', 'Orelsan', 'Rap', 'orelsan.jpg'),
       ('88a5404d-b027-481b-985f-1b86937050f0', 'IAM', 'Rap', 'iam.jpg'),
       ('7f0240fe-5a7b-4679-a0f3-6f95d64e186e', 'NTM', 'Rap', 'ntm.jpg'),
       ('31b1a800-49dc-43d3-bfd3-e7cf63b26447', 'Tryo', 'Reggae', 'tryo.jpg'),
       ('34ade196-6a0f-46d2-a360-c7d084fca4b5', 'Lea Castel', 'Pop', 'leacastel.jpg'),
       ('4794592e-3f8c-4737-91eb-058a8cd5233e', 'Shym', 'Pop', 'shym.jpg'),
       ('842af1aa-2de8-4568-941d-e37c4f47040d', 'Lara Fabian', 'Pop', 'larafabian.jpg'),
       ('250f097e-11c7-44d9-b7ee-ca16f35f0c71', 'Calogero', 'Pop', 'calogero.jpg'),
       ('808f6413-6a3e-4989-b40c-befd4027f2dc', 'Garou', 'Pop', 'garou.jpg'),
       ('6b9ff23d-8c18-417a-9b85-431bb6b71413', 'Pascal Obispo', 'Pop', 'pascalobispo.jpg'),
       ('586e381a-2e5e-4037-a17b-edf0266c7310', 'Florent Pagny', 'Pop', 'florentpagny.jpg'),
       ('8dfe5baa-b686-4aa0-aa48-b5d07bbcf037', 'Michel Sardou', 'Chanson', 'michelsardou.jpg'),
       ('867d4934-204c-41ca-beb2-02a679a69e5e', 'Mylène Farmer', 'Pop', 'mylenefarmer.jpg');


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
       (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Imany'), (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Shaka Ponk'), (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Clara Luciani'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Julien Doré'), (SELECT id FROM public.style WHERE name = 'Pop');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Jeanne Added'),
       (SELECT id FROM public.style WHERE name = 'Rock');

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
       (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Gojira'), (SELECT id FROM public.style WHERE name = 'Metal');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Camille'),
       (SELECT id FROM public.style WHERE name = 'Classical');

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
SELECT (SELECT id FROM public.artists WHERE name = 'Lou Doillon'),
       (SELECT id FROM public.style WHERE name = 'Classical');

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
SELECT (SELECT id FROM public.artists WHERE name = 'Kassav'), (SELECT id FROM public.style WHERE name = 'Classical');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Johnny Hallyday'),
       (SELECT id FROM public.style WHERE name = 'Rock');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Charles Aznavour'),
       (SELECT id FROM public.style WHERE name = 'Chanson');

INSERT INTO public.artists2style (artist_id, style_id)
SELECT (SELECT id FROM public.artists WHERE name = 'Mylène Farmer'), (SELECT id FROM public.style WHERE name = 'Pop');


-- Insertion des spectacles
INSERT INTO public.shows (id, title, description, video, begin)
VALUES ('14808e51-d1b6-4539-8596-66a9e39e01c9', 'Daft Punk Show', 'Un concert unique avec Daft Punk',
        '/videos/daftpunk.mp4',
        '2024-12-31 22:00:00'),
       ('05cf1397-1bf3-4227-aa5a-063c6b3e14e8', 'Phoenix Live', 'Phoenix en live à Paris', '/videos/phoenix.mp4',
        '2024-11-15 20:00:00'),
       ('2ccfe7d7-adaf-492a-abb4-78065bd69ae6', 'Christine and the Queens', 'Christine and the Queens en concert',
        '/videos/christine.mp4',
        '2024-10-15 20:00:00');

-- Insertion des images de spectacles
INSERT INTO public.images (id, path, show_id)
VALUES ('dc0596b0-9ac2-448e-b258-eff68fb81691', '/images/daftpunk.jpg',
        (SELECT id FROM public.shows WHERE title = 'Daft Punk Show')),
       ('157d8626-58d4-423f-91fc-7b0155baa241', '/images/phoenix.jpg',
        (SELECT id FROM public.shows WHERE title = 'Phoenix Live')),
       ('df220d31-9506-40f5-ad71-dd0a0ac48c52', '/images/christine.jpg',
        (SELECT id FROM public.shows WHERE title = 'Christine and the Queens'));


-- Insertion des performances d'artistes
INSERT INTO public.perform (show_id, artist_id)
VALUES ((SELECT id FROM public.shows WHERE title = 'Daft Punk Show'),
        (SELECT id FROM public.artists WHERE name = 'Daft Punk')),
       ((SELECT id FROM public.shows WHERE title = 'Phoenix Live'),
        (SELECT id FROM public.artists WHERE name = 'Phoenix'));


-- DATA FOR PARTY
\connect
nrv_party;

-- Insertion des fêtes (party)
INSERT INTO public.party (id, name, theme, date, begin, place_id, show1_id, show2_id, show3_id, price)
VALUES ('a0b7566b-6fdd-4e34-bbab-41d882de9c07', 'Birthday Bash', 'Anniversaire', '2024-12-25 20:00:00', '2024-12-25 21:00:00',
        '340cf1fe-6344-4e93-ab6a-347c7e461d36', '14808e51-d1b6-4539-8596-66a9e39e01c9', '14808e51-d1b6-4539-8596-66a9e39e01c9', NULL, 30),
       ('8243ea21-155b-4ac9-b75e-f66fc142c2ef', 'Music Fiesta', 'Musique', '2024-11-01 18:00:00', '2024-11-01 19:00:00', 'b6b101d5-563e-4530-a3bb-43be12ea1053',
        'df220d31-9506-40f5-ad71-dd0a0ac48c52', NULL, NULL, 25);

-- DATA FOR TICKETS
\connect
nrv_ticket;

INSERT INTO public.tickets (id, name, price, quantity, party_id)
VALUES ('cec7ef16-66db-4916-96cd-4e4a2057ae8c', 'Birthday Bash ticket', 30, 100000,
        'a0b7566b-6fdd-4e34-bbab-41d882de9c07'),
       ('eaa814ee-398e-435e-950c-32bc56cf0c90', 'Music Fiesta ticket', 50, 9000,
        '8243ea21-155b-4ac9-b75e-f66fc142c2ef');

INSERT INTO public.selledtickets (id, name, price, user_id, ticket_id, party_id)
VALUES ('ef54b2c6-15bb-498f-9118-064db56f611b', 'Birthday Bash ticket', 30,
        '669d5162-84b0-4edc-b043-3ccfa71eb0a9', (SELECT id FROM public.tickets WHERE name = 'Birthday Bash ticket'),
        (SELECT party_id FROM public.tickets WHERE name = 'Birthday Bash ticket')),
       ('d45fcf22-e954-4639-9c73-8fb0040e1335', 'Music Fiesta ticket', 50,
        '669d5162-84b0-4edc-b043-3ccfa71eb0a9', (SELECT id FROM public.tickets WHERE name = 'Music Fiesta ticket'),
        (SELECT party_id FROM public.tickets WHERE name = 'Music Fiesta ticket'));

INSERT INTO public.cards (id, user_id, total_price)
VALUES ('d85544dd-c85b-4f9b-a600-52f91388d6d0', '669d5162-84b0-4edc-b043-3ccfa71eb0a9', 80);

INSERT INTO public.card_content (card_id, ticket_id, quantity)
VALUES ((SELECT id FROM public.cards WHERE user_id = '669d5162-84b0-4edc-b043-3ccfa71eb0a9'),
        (SELECT id FROM public.tickets WHERE name = 'Birthday Bash ticket'), 1),
       ((SELECT id FROM public.cards WHERE user_id = '669d5162-84b0-4edc-b043-3ccfa71eb0a9'),
        (SELECT id FROM public.tickets WHERE name = 'Music Fiesta ticket'), 1);