-- add table prefix if you have one
DELETE FROM core_config_data WHERE path like 'ffuenf_categoryproductsortbackend_setup/%';
DELETE FROM core_config_data WHERE path = 'advanced/modules_disable_output/Ffuenf_CategoryProductSortBackend';
DELETE FROM core_resource WHERE code = 'ffuenf_categoryproductsortbackend_setup';