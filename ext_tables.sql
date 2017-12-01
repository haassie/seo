#
# Table structure for table 'pages'
#
CREATE TABLE pages (
	seo_title varchar(255) DEFAULT '' NOT NULL,
	canonical_url varchar(1024) DEFAULT '' NOT NULL,
	robot_index smallint(5) unsigned DEFAULT '0' NOT NULL,
	robot_follow smallint(5) unsigned DEFAULT '0' NOT NULL,
	og_title varchar(255) DEFAULT '' NOT NULL,
	og_description text,
	og_image int(11) DEFAULT '0' NOT NULL,
	og_type varchar(50) DEFAULT 'website' NOT NULL,
);
