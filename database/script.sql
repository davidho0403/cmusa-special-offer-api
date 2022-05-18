CREATE TABLE store (
    store_id INT UNSIGNED PRIMARY KEY auto_increment COMMENT '店家編號',
    store_name VARCHAR(50) COMMENT '店名',
    store_address VARCHAR(100) COMMENT '地址',
    store_phone VARCHAR(50) COMMENT '電話'
) COMMENT '特約商店';