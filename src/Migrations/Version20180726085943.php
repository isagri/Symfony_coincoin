<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180726085943 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_891141C798260155');
        $this->addSql('DROP INDEX IDX_891141C712469DE2');
        $this->addSql('DROP INDEX IDX_891141C7F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__advertisment AS SELECT id, author_id, category_id, region_id, title, description, creation_date, photo, active, price FROM advertisment');
        $this->addSql('DROP TABLE advertisment');
        $this->addSql('CREATE TABLE advertisment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, category_id INTEGER DEFAULT NULL, region_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, creation_date DATE DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL COLLATE BINARY, active BOOLEAN DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, CONSTRAINT FK_891141C7F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_891141C712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_891141C798260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO advertisment (id, author_id, category_id, region_id, title, description, creation_date, photo, active, price) SELECT id, author_id, category_id, region_id, title, description, creation_date, photo, active, price FROM __temp__advertisment');
        $this->addSql('DROP TABLE __temp__advertisment');
        $this->addSql('CREATE INDEX IDX_891141C798260155 ON advertisment (region_id)');
        $this->addSql('CREATE INDEX IDX_891141C712469DE2 ON advertisment (category_id)');
        $this->addSql('CREATE INDEX IDX_891141C7F675F31B ON advertisment (author_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('DROP INDEX UNIQ_8D93D649444F97DD');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, firstname, lastname, phone, email, password, roles FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, region_id INTEGER DEFAULT NULL, firstname VARCHAR(255) NOT NULL COLLATE BINARY, lastname VARCHAR(255) NOT NULL COLLATE BINARY, phone VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, password VARCHAR(255) NOT NULL COLLATE BINARY, roles CLOB NOT NULL COLLATE BINARY --(DC2Type:json_array)
        , CONSTRAINT FK_8D93D64998260155 FOREIGN KEY (region_id) REFERENCES region (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO user (id, firstname, lastname, phone, email, password, roles) SELECT id, firstname, lastname, phone, email, password, roles FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649444F97DD ON user (phone)');
        $this->addSql('CREATE INDEX IDX_8D93D64998260155 ON user (region_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_891141C7F675F31B');
        $this->addSql('DROP INDEX IDX_891141C712469DE2');
        $this->addSql('DROP INDEX IDX_891141C798260155');
        $this->addSql('CREATE TEMPORARY TABLE __temp__advertisment AS SELECT id, author_id, category_id, region_id, title, description, creation_date, photo, active, price FROM advertisment');
        $this->addSql('DROP TABLE advertisment');
        $this->addSql('CREATE TABLE advertisment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, category_id INTEGER DEFAULT NULL, region_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, creation_date DATE DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, active BOOLEAN DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL)');
        $this->addSql('INSERT INTO advertisment (id, author_id, category_id, region_id, title, description, creation_date, photo, active, price) SELECT id, author_id, category_id, region_id, title, description, creation_date, photo, active, price FROM __temp__advertisment');
        $this->addSql('DROP TABLE __temp__advertisment');
        $this->addSql('CREATE INDEX IDX_891141C7F675F31B ON advertisment (author_id)');
        $this->addSql('CREATE INDEX IDX_891141C712469DE2 ON advertisment (category_id)');
        $this->addSql('CREATE INDEX IDX_891141C798260155 ON advertisment (region_id)');
        $this->addSql('DROP INDEX UNIQ_8D93D649444F97DD');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74');
        $this->addSql('DROP INDEX IDX_8D93D64998260155');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, firstname, lastname, phone, email, password, roles FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json_array)
        )');
        $this->addSql('INSERT INTO user (id, firstname, lastname, phone, email, password, roles) SELECT id, firstname, lastname, phone, email, password, roles FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649444F97DD ON user (phone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }
}
