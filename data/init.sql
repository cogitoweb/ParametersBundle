CREATE TABLE cogitoweb_parameters_bundle
(
	id SERIAL NOT NULL,
	key VARCHAR(255) NOT NULL,
	value TEXT DEFAULT NULL,
	
	createdBy VARCHAR(255) DEFAULT NULL,
	updatedBy VARCHAR(255) DEFAULT NULL,
	createdAt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
	updatedAt TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,

	PRIMARY KEY(id)
);
CREATE UNIQUE INDEX IDX_cogitoweb_parameters_bundle_key ON cogitoweb_parameters_bundle (key);