<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230606212031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE language_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE country_language (country_id INT NOT NULL, language_id INT NOT NULL, PRIMARY KEY(country_id, language_id))');
        $this->addSql('CREATE INDEX IDX_E7112008F92F3E70 ON country_language (country_id)');
        $this->addSql('CREATE INDEX IDX_E711200882F1BAF4 ON country_language (language_id)');
        $this->addSql('CREATE TABLE language (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE country_language ADD CONSTRAINT FK_E7112008F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE country_language ADD CONSTRAINT FK_E711200882F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE country ADD description TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE country ALTER created_at SET NOT NULL');
        $this->addSql('ALTER TABLE country ALTER updated_at SET NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE language_id_seq CASCADE');
        $this->addSql('ALTER TABLE country_language DROP CONSTRAINT FK_E7112008F92F3E70');
        $this->addSql('ALTER TABLE country_language DROP CONSTRAINT FK_E711200882F1BAF4');
        $this->addSql('DROP TABLE country_language');
        $this->addSql('DROP TABLE language');
        $this->addSql('ALTER TABLE country DROP description');
        $this->addSql('ALTER TABLE country ALTER created_at DROP NOT NULL');
        $this->addSql('ALTER TABLE country ALTER updated_at DROP NOT NULL');
    }
}
