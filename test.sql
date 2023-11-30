
USE UniGym;

INSERT INTO clients (document, name, surname, height, weight, gender, birth_date, active, type_client_id, type_document_id, degree_id, created_at, updated_at)
VALUES ('123456789', 'Nicolas', 'Suarez', 170, 70, 'Masculino', '2000-02-08', 1, 1, 1, 2, '2023-11-27', '2023-11-27');

-- insert con fechas de (2023-11-01 a 2023-11-30)
INSERT INTO test_forces (benchPress, benchPressReps, pulleyOpenHigh, pulleyOpenHighReps, barbellBicepsCurl, barbellBicepsCurlReps, legFlexion, legFlexionReps, legExtension, legExtensionReps, legFlexExt, legFlexExtReps, date, client_id)
VALUES (120, 10, 50, 10, 30, 10, 50, 10, 50, 10, 100, 10, '2023-11-01', 387);
INSERT INTO test_forces (benchPress, benchPressReps, pulleyOpenHigh, pulleyOpenHighReps, barbellBicepsCurl, barbellBicepsCurlReps, legFlexion, legFlexionReps, legExtension, legExtensionReps, legFlexExt, legFlexExtReps, date, client_id)
VALUES (120, 10, 50, 10, 30, 10, 50, 10, 50, 10, 100, 10, '2023-11-02', 387);
INSERT INTO test_forces (benchPress, benchPressReps, pulleyOpenHigh, pulleyOpenHighReps, barbellBicepsCurl, barbellBicepsCurlReps, legFlexion, legFlexionReps, legExtension, legExtensionReps, legFlexExt, legFlexExtReps, date, client_id)
VALUES (120, 10, 50, 10, 30, 10, 50, 10, 50, 10, 100, 10, '2023-11-03', 387);
INSERT INTO test_forces (benchPress, benchPressReps, pulleyOpenHigh, pulleyOpenHighReps, barbellBicepsCurl, barbellBicepsCurlReps, legFlexion, legFlexionReps, legExtension, legExtensionReps, legFlexExt, legFlexExtReps, date, client_id)
VALUES (120, 10, 50, 10, 30, 10, 50, 10, 50, 10, 100, 10, '2023-11-04', 387);
INSERT INTO test_forces (benchPress, benchPressReps, pulleyOpenHigh, pulleyOpenHighReps, barbellBicepsCurl, barbellBicepsCurlReps, legFlexion, legFlexionReps, legExtension, legExtensionReps, legFlexExt, legFlexExtReps, date, client_id)
VALUES (120, 10, 50, 10, 30, 10, 50, 10, 50, 10, 100, 10, '2023-11-05', 387);

-- insert con fechas de (2023-11-01 a 2023-11-30)
INSERT INTO test_forces (benchPress, benchPressReps, pulleyOpenHigh, pulleyOpenHighReps, barbellBicepsCurl, barbellBicepsCurlReps, legFlexion, legFlexionReps, legExtension, legExtensionReps, legFlexExt, legFlexExtReps, date, client_id)
VALUES (120, 10, 50, 10, 30, 10, 50, 10, 50, 10, 100, 10, '2023-11-01', 1);
INSERT INTO test_forces (benchPress, benchPressReps, pulleyOpenHigh, pulleyOpenHighReps, barbellBicepsCurl, barbellBicepsCurlReps, legFlexion, legFlexionReps, legExtension, legExtensionReps, legFlexExt, legFlexExtReps, date, client_id)
VALUES (120, 10, 50, 10, 30, 10, 50, 10, 50, 10, 100, 10, '2023-11-02', 2);
INSERT INTO test_forces (benchPress, benchPressReps, pulleyOpenHigh, pulleyOpenHighReps, barbellBicepsCurl, barbellBicepsCurlReps, legFlexion, legFlexionReps, legExtension, legExtensionReps, legFlexExt, legFlexExtReps, date, client_id)
VALUES (120, 10, 50, 10, 30, 10, 50, 10, 50, 10, 100, 10, '2023-11-03', 3);
INSERT INTO test_forces (benchPress, benchPressReps, pulleyOpenHigh, pulleyOpenHighReps, barbellBicepsCurl, barbellBicepsCurlReps, legFlexion, legFlexionReps, legExtension, legExtensionReps, legFlexExt, legFlexExtReps, date, client_id)
VALUES (120, 10, 50, 10, 30, 10, 50, 10, 50, 10, 100, 10, '2023-11-04', 4);
INSERT INTO test_forces (benchPress, benchPressReps, pulleyOpenHigh, pulleyOpenHighReps, barbellBicepsCurl, barbellBicepsCurlReps, legFlexion, legFlexionReps, legExtension, legExtensionReps, legFlexExt, legFlexExtReps, date, client_id)
VALUES (120, 10, 50, 10, 30, 10, 50, 10, 50, 10, 100, 10, '2023-11-05', 5);



SELECT * from test_forces where client_id = 387;

INSERT INTO test_anthropometries (bicepCircumference, tricepCircumference, carpusPerimeter, subscapular, suprailiac, client_id)
VALUES (120, 10, 50, 10, 30, 387);

SELECT * from test_anthropometries where client_id = 387;

INSERT INTO test_forestries (restingPulse, effortPulse, recoveryPulse, date, client_id)
VALUES (74, 156, 132, '2023-11-27', 387);

-- SELECT * from clients;

SELECT * from test_forestries where client_id = 387;

INSERT INTO attendances (date_attendance, client_id, created_at, updated_at)
VALUES ('2023-11-27', 387, '2023-11-27', '2023-11-27');

SELECT * from attendances where client_id = 387;

SELECT * from users;


DELETE FROM test_forestries;

INSERT INTO clients (document, name, surname, height, weight, gender, birth_date, active, type_client_id, type_document_id, degree_id, created_at, updated_at)
VALUES ('123456789', 'Nicolas', 'Suarez', 170, 70, 'Masculino', '2000-02-08', 1, 1, 1, 2, '2023-11-27', '2023-11-27');


UPDATE clients
SET birth_date = '2006-02-02'
WHERE id = 387;


INSERT INTO test_forestries(restingPulse, effortPulse, recoveryPulse, VO2max, client_id)
VALUES (12, 13, 14, 24, 387);

INSERT INTO test_forestries(restingPulse, effortPulse, recoveryPulse, VO2max, client_id)
VALUES (12, 13, 14, 34, 387);

INSERT INTO test_forestries(restingPulse, effortPulse, recoveryPulse, VO2max, client_id)
VALUES (12, 13, 14, 44, 387);

INSERT INTO test_forestries(restingPulse, effortPulse, recoveryPulse, VO2max, client_id)
VALUES (12, 13, 14, 54, 387);

INSERT INTO test_forestries(restingPulse, effortPulse, recoveryPulse, VO2max, client_id)
VALUES (12, 13, 14, 57, 387);

select * from test_forestries where client_id = 387;


select * from clients where id = 387;

