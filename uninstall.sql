-- add table prefix if you have one
DELETE FROM core_config_data WHERE path like 'categoryproductsortbackend/%';
DELETE FROM core_resource WHERE code = 'categoryproductsortbackend_setup';