<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241121142014 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, assigned_team_id INT DEFAULT NULL, titre VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, status VARCHAR(255) NOT NULL, start_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', end_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', location VARCHAR(255) NOT NULL, danger_level INT NOT NULL, INDEX IDX_9067F23C23F46021 (assigned_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pouvoir (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, level INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE super_hero (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, alter_ego VARCHAR(255) DEFAULT NULL, est_disponible TINYINT(1) NOT NULL, energie_level INT NOT NULL, biographie LONGTEXT NOT NULL, image_nom VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE super_hero_pouvoir (super_hero_id INT NOT NULL, pouvoir_id INT NOT NULL, INDEX IDX_8E6512CBB62BE361 (super_hero_id), INDEX IDX_8E6512CBC8A705F8 (pouvoir_id), PRIMARY KEY(super_hero_id, pouvoir_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, leader_id INT NOT NULL, current_mission_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, est_active TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_C4E0A61F73154ED4 (leader_id), UNIQUE INDEX UNIQ_C4E0A61F61D767E2 (current_mission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team_super_hero (team_id INT NOT NULL, super_hero_id INT NOT NULL, INDEX IDX_83E4152A296CD8AE (team_id), INDEX IDX_83E4152AB62BE361 (super_hero_id), PRIMARY KEY(team_id, super_hero_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C23F46021 FOREIGN KEY (assigned_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE super_hero_pouvoir ADD CONSTRAINT FK_8E6512CBB62BE361 FOREIGN KEY (super_hero_id) REFERENCES super_hero (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE super_hero_pouvoir ADD CONSTRAINT FK_8E6512CBC8A705F8 FOREIGN KEY (pouvoir_id) REFERENCES pouvoir (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F73154ED4 FOREIGN KEY (leader_id) REFERENCES super_hero (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F61D767E2 FOREIGN KEY (current_mission_id) REFERENCES mission (id)');
        $this->addSql('ALTER TABLE team_super_hero ADD CONSTRAINT FK_83E4152A296CD8AE FOREIGN KEY (team_id) REFERENCES team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE team_super_hero ADD CONSTRAINT FK_83E4152AB62BE361 FOREIGN KEY (super_hero_id) REFERENCES super_hero (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C23F46021');
        $this->addSql('ALTER TABLE super_hero_pouvoir DROP FOREIGN KEY FK_8E6512CBB62BE361');
        $this->addSql('ALTER TABLE super_hero_pouvoir DROP FOREIGN KEY FK_8E6512CBC8A705F8');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F73154ED4');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F61D767E2');
        $this->addSql('ALTER TABLE team_super_hero DROP FOREIGN KEY FK_83E4152A296CD8AE');
        $this->addSql('ALTER TABLE team_super_hero DROP FOREIGN KEY FK_83E4152AB62BE361');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE pouvoir');
        $this->addSql('DROP TABLE super_hero');
        $this->addSql('DROP TABLE super_hero_pouvoir');
        $this->addSql('DROP TABLE team');
        $this->addSql('DROP TABLE team_super_hero');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
