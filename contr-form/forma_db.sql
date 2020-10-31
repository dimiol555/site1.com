DROP TABLE IF EXISTS Fields_message;

DROP TABLE IF EXISTS Fields;

DROP TABLE IF EXISTS Message;

DROP TABLE IF EXISTS Form;

CREATE TABLE  Form (
    ID_form INT NOT NULL AUTO_INCREMENT,
    NameForm CHAR (50) NOT NULL,
    PRIMARY KEY (ID_form)
);

INSERT INTO Form VALUES
(NULL, 'form444'),
(NULL, 'form888');

CREATE TABLE Fields (
    ID_field INT NOT NULL AUTO_INCREMENT,
    FormID INT,
    NameField VARCHAR (50) NOT NULL,
    type VARCHAR (50) NOT NULL,
    placeholder VARCHAR (50),
    validation VARCHAR (50) NOT NULL,
    send VARCHAR (50) NOT NULL,
    options TEXT,
    PRIMARY KEY (ID_field),
    FOREIGN KEY (FormID) REFERENCES Form (ID_form)
);

INSERT INTO Fields VALUES
(NULL, 1, 'f_name', 'Text', 'Name', 'not_empty', 'From: ', NULL),
(NULL, 1, 'subject', 'Text', 'Subject', 'not_empty', 'Subject: ', NULL),
(NULL, 1, 'mobile', 'Text', 'Mobile', 'mobile', 'Mobile: ', NULL),
(NULL, 1, 'email', 'Text', 'E-mail', 'email', 'From e-mail: ', NULL),
(NULL, 1, 'message', 'Textarea', 'Message', 'not_empty', 'Message: ', NULL),
(NULL, 1, 'select', 'Select', NULL, 'selected', 'City: ', '{"default" : "Select City", "value1" : "Kharkov","value2" : "Kiev","value3" : "Dnepr"}'),
(NULL, 1, 'checkbox', 'Checkbox', NULL, 'checked', 'Languages: ', '{"value1" : "English","value2" : "German","value3" : "French"}'),
(NULL, 1, 'radio', 'Radio', NULL, 'checked', 'Attainments: ', '{"value1" : "PHP+HTML","value2" : "PHP+HTML+CSS","value3" : "PHP"}'),

(NULL, 2, 'f_name', 'Text', 'Name', 'not_empty', 'From: ', NULL),
(NULL, 2, 'mobile', 'Text', 'Mobile', 'mobile', 'Mobile: ', NULL),
(NULL, 2, 'email', 'Text', 'E-mail', 'email', 'From e-mail: ', NULL),
(NULL, 2, 'message', 'Textarea', 'Message', 'not_empty', 'Message: ', NULL),
(NULL, 2, 'checkbox', 'Checkbox', NULL, 'checked', 'Languages: ', '{"value1" : "English","value2" : "German","value3" : "French"}');

CREATE TABLE Message (
     ID INT NOT NULL AUTO_INCREMENT,
     FormID INT NOT NULL ,
     Message TEXT,
     Data DATETIME DEFAULT CURRENT_TIMESTAMP,
     PRIMARY KEY (ID),
     FOREIGN KEY (FormID) REFERENCES Form (ID_form)
);

CREATE TABLE Fields_message (
    ID INT NOT NULL AUTO_INCREMENT,
    MessageID INT NOT NULL,
    FieldID INT NOT NULL,
    Value TEXT,
    PRIMARY KEY (ID),
    FOREIGN KEY (MessageID) REFERENCES Message (ID),
    FOREIGN KEY (FieldID) REFERENCES Fields (ID_field)
)

