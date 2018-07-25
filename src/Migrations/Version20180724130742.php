<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180724130742 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_891141C7F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__advertisment AS SELECT id, author_id, title, description, creation_date FROM advertisment');
        $this->addSql('DROP TABLE advertisment');
        $this->addSql('CREATE TABLE advertisment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB NOT NULL COLLATE BINARY, creation_date DATE DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_891141C7F675F31B FOREIGN KEY (author_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO advertisment (id, author_id, title, description, creation_date) SELECT id, author_id, title, description, creation_date FROM __temp__advertisment');
        $this->addSql('DROP TABLE __temp__advertisment');
        $this->addSql('CREATE INDEX IDX_891141C7F675F31B ON advertisment (author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_891141C7F675F31B');
        $this->addSql('CREATE TEMPORARY TABLE __temp__advertisment AS SELECT id, author_id, title, description, creation_date FROM advertisment');
        $this->addSql('DROP TABLE advertisment');
        $this->addSql('CREATE TABLE advertisment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author_id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, creation_date DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO advertisment (id, author_id, title, description, creation_date) SELECT id, author_id, title, description, creation_date FROM __temp__advertisment');
        $this->addSql('DROP TABLE __temp__advertisment');
        $this->addSql('CREATE INDEX IDX_891141C7F675F31B ON advertisment (author_id)');
    }
}
