<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240121171358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE user_app_visited_country_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE user_app_visited_country (id INT NOT NULL, user_app_id INT DEFAULT NULL, country_id INT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2981B8671CD53A10 ON user_app_visited_country (user_app_id)');
        $this->addSql('CREATE INDEX IDX_2981B867F92F3E70 ON user_app_visited_country (country_id)');
        $this->addSql('ALTER TABLE user_app_visited_country ADD CONSTRAINT FK_2981B8671CD53A10 FOREIGN KEY (user_app_id) REFERENCES user_app (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_app_visited_country ADD CONSTRAINT FK_2981B867F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_app_country DROP CONSTRAINT fk_173580be1cd53a10');
        $this->addSql('ALTER TABLE user_app_country DROP CONSTRAINT fk_173580bef92f3e70');
        $this->addSql('DROP TABLE user_app_country');
        $this->addSql('ALTER TABLE messenger_messages ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER available_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER delivered_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE user_app_visited_country_id_seq CASCADE');
        $this->addSql('CREATE TABLE user_app_country (user_app_id INT NOT NULL, country_id INT NOT NULL, PRIMARY KEY(user_app_id, country_id))');
        $this->addSql('CREATE INDEX idx_173580bef92f3e70 ON user_app_country (country_id)');
        $this->addSql('CREATE INDEX idx_173580be1cd53a10 ON user_app_country (user_app_id)');
        $this->addSql('ALTER TABLE user_app_country ADD CONSTRAINT fk_173580be1cd53a10 FOREIGN KEY (user_app_id) REFERENCES user_app (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_app_country ADD CONSTRAINT fk_173580bef92f3e70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_app_visited_country DROP CONSTRAINT FK_2981B8671CD53A10');
        $this->addSql('ALTER TABLE user_app_visited_country DROP CONSTRAINT FK_2981B867F92F3E70');
        $this->addSql('DROP TABLE user_app_visited_country');
        $this->addSql('ALTER TABLE messenger_messages ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER available_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE messenger_messages ALTER delivered_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS NULL');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS NULL');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS NULL');
    }
}
