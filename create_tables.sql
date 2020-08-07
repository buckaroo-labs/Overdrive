
CREATE DATABASE IF NOT EXISTS gold DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE gold;

DROP TABLE IF EXISTS application;
DROP TABLE IF EXISTS APPLICATION;

CREATE TABLE application
  (    APP_ID INT,
       APP_NAME VARCHAR(30) NOT NULL ,
       INS_DATE DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL ,
       INS_USER VARCHAR(30) NOT NULL ,
       UPD_DATE DATETIME,
       UPD_USER VARCHAR(30),
        PRIMARY KEY (APP_ID));

DROP TABLE IF EXISTS app_support_team;
DROP TABLE IF EXISTS APP_SUPPORT_TEAM;
 
CREATE TABLE app_support_team
    (    APP_ID INT NOT NULL ,
         TEAM_ID INT NOT NULL ,
         SUPPORT_TIER INT,
         INS_DATE DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL ,
         INS_USER VARCHAR(30) NOT NULL ,
         UPD_DATE DATETIME,
        UPD_USER VARCHAR(30));

DROP TABLE IF EXISTS db_data_census;
DROP TABLE IF EXISTS DB_DATA_CENSUS;
        
 CREATE TABLE db_data_census
  (    USERNAME VARCHAR(30) NOT NULL ,
       DOMAIN VARCHAR(80) NOT NULL ,
       CENSUS_DATE DATETIME NOT NULL ,
       SIZE_MB INT NOT NULL ,
        PRIMARY KEY (USERNAME, DOMAIN, CENSUS_DATE)
);


DROP TABLE IF EXISTS ENVIRONMENT;
DROP TABLE IF EXISTS environment;

 CREATE TABLE environment
  (    ENV_ID INT,
       ENV_NAME VARCHAR(15) NOT NULL ,
       APP_ID INT NOT NULL ,
       ALIAS VARCHAR(15),
       ENV_CLASS VARCHAR(15),
       INS_DATE DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL ,
       INS_USER VARCHAR(30) NOT NULL ,
       UPD_DATE DATETIME,
       UPD_USER VARCHAR(30),
PRIMARY KEY (ENV_ID)
);

DROP TABLE IF EXISTS HOST;
DROP TABLE IF EXISTS host;
 
  CREATE TABLE host
   (    HOSTNAME VARCHAR(30) NOT NULL ,
        IP VARCHAR(30),
        PROCESSOR_TYPE VARCHAR(20),
        PROCESSOR_MHZ INT,
        CPU_COUNT INT,
        SUPPORT_TEAM VARCHAR(30),
        DATACENTER VARCHAR(30),
        WARRANTY_EXPIRES DATETIME,
        EOSL DATETIME,
        OS VARCHAR(30),
        OS_VERSION VARCHAR(30),
        MODEL VARCHAR(150),
        DOMAIN VARCHAR(50),
        MEMORY_MB INT,
        COMMENTS VARCHAR(100),
        INS_DATE DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL ,
        INS_USER VARCHAR(30) NOT NULL ,
        UPD_DATE DATETIME,
        UPD_USER VARCHAR(30),
        TIMEZONE VARCHAR(25),
        HEARTBEAT DATETIME,
        CITY VARCHAR(30),
PRIMARY KEY (HOSTNAME)
);
 

DROP TABLE IF EXISTS m_env_service;
DROP TABLE IF EXISTS M_ENV_SERVICE;

 CREATE TABLE m_env_service
  (    ENV_ID INT NOT NULL ,
       SERVICENAME VARCHAR(80) NOT NULL ,
       INS_DATE DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL ,
       INS_USER VARCHAR(30) NOT NULL ,
       UPD_DATE DATETIME,
       UPD_USER VARCHAR(30),
       ENV_SVC_ROLE VARCHAR(20),
PRIMARY KEY (ENV_ID, SERVICENAME)
);
 
DROP TABLE IF EXISTS PAGE_USAGE;
DROP TABLE IF EXISTS page_usage;

  CREATE TABLE page_usage
  (    USERNAME VARCHAR(10),
       REQ_DATE DATETIME DEFAULT CURRENT_TIMESTAMP,
       IPADDR VARCHAR(50),
       REQ_URI TEXT
  );
  
DROP TABLE IF EXISTS SERVICE;
  
DROP TABLE IF EXISTS service;
CREATE TABLE service
 (    SERVICENAME VARCHAR(80) NOT NULL ,
      ADMIN_URL VARCHAR(250),
      URL VARCHAR(250),
      ALIAS VARCHAR(50),
      STATUS VARCHAR(10) DEFAULT 'ACTIVE' NOT NULL ,
      SERVER_VERSION VARCHAR(30),
      SERVER_BRAND VARCHAR(30),
      SERVICE_TYPE VARCHAR(30),
      IP VARCHAR(30),
      PORT INT,
      LOAD_BALANCER VARCHAR(25),
      SUPPORT_CONTACT VARCHAR(100),
      HOST_USERNAME VARCHAR(30),
      HOST_MACHINE VARCHAR(30),
      VHOST_YN CHAR(1),
      JCONSOLE_PORT INT,
      MEMORY_MB INT,
      MEM_ARGS TEXT,
      INS_DATE DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL ,
      INS_USER VARCHAR(30) NOT NULL ,
      UPD_DATE DATETIME,
      UPD_USER VARCHAR(30),
      ORACLENET_FQDN VARCHAR(50),
      SVC_CLUSTER VARCHAR(30),
      STATUS_MSG VARCHAR(255),
      SSL_PORT INT,
PRIMARY KEY (SERVICENAME)
);
  

DROP TABLE IF EXISTS support_team;
DROP TABLE IF EXISTS SUPPORT_TEAM;
 
 CREATE TABLE support_team
  (    ID INT NOT NULL ,
       DISPLAY_NAME VARCHAR(30) NOT NULL ,
       EMAIL VARCHAR(30),
       HOME_PAGE VARCHAR(150),
       INS_DATE DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL ,
       INS_USER VARCHAR(30) NOT NULL ,
       UPD_DATE DATETIME,
       UPD_USER VARCHAR(30),
PRIMARY KEY (ID)
);
 

 
 
CREATE OR REPLACE VIEW server_directory AS
  select h.hostname, h.domain, h.os , s.servicename, s.service_type , e.env_name
, e.env_class, e.env_id, e.APP_ID, a.app_name, s.host_username, h.heartbeat, h.city, s.svc_cluster
from service s 
 LEFT JOIN host as h ON s.host_machine = h.hostname
 LEFT JOIN m_env_service as m ON s.servicename = m.servicename
 LEFT JOIN environment as e ON m.env_id = e.env_id
 LEFT JOIN application  as a ON e.APP_ID = a.APP_ID
where ifnull(s.status,'ACTIVE')='ACTIVE';

   

 CREATE OR REPLACE VIEW database_directory AS
 select h.hostname, h.domain, h.os , s.servicename, s.service_type , e.env_name, e.env_class,
 e.env_id, e.APP_ID, a.app_name, 
 s.port, s.server_brand, s.oraclenet_fqdn, s.svc_cluster, 
 CASE WHEN s.server_brand='Oracle' THEN CONCAT('orcl://',IFNULL(s.oraclenet_fqdn,CONCAT(h.hostname,'.',h.domain)),
 CASE WHEN ISNULL(s.port) THEN '' ELSE CONCAT(':',s.port,'/', ifnull(s.svc_cluster,s.servicename) ) END) ELSE '' END as URL
 from service s 
 LEFT JOIN host as h ON s.host_machine = h.hostname
 LEFT JOIN m_env_service as m ON s.servicename = m.servicename
 LEFT JOIN environment as e ON m.env_id = e.env_id
 LEFT JOIN application  as a ON e.APP_ID = a.APP_ID
 where ifnull(s.status,'ACTIVE')='ACTIVE'
 and s.service_type='Database';

create USER 'gold_app'@'localhost' IDENTIFIED WITH mysql_native_password BY 'infrastuKcture';  
grant select on gold.* to  'gold_app'@'localhost';
grant insert on gold.page_usage to  'gold_app'@'localhost' ;
