<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502213938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_country (user_id INT NOT NULL, country_id INT NOT NULL, INDEX IDX_B7ED76CA76ED395 (user_id), INDEX IDX_B7ED76CF92F3E70 (country_id), PRIMARY KEY(user_id, country_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_country ADD CONSTRAINT FK_B7ED76CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_country ADD CONSTRAINT FK_B7ED76CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_country DROP FOREIGN KEY FK_B7ED76CA76ED395');
        $this->addSql('ALTER TABLE user_country DROP FOREIGN KEY FK_B7ED76CF92F3E70');
        $this->addSql('DROP TABLE user_country');
        $this->addSql('DROP INDEX UNIQ_8D93D649E7927C74 ON user');
    }
}
