<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200709214327 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE booking_lesson (booking_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_43EE4F0D3301C60 (booking_id), INDEX IDX_43EE4F0DCDF80196 (lesson_id), PRIMARY KEY(booking_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_lesson ADD CONSTRAINT FK_43EE4F0D3301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_lesson ADD CONSTRAINT FK_43EE4F0DCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE lesson_field');
        $this->addSql('DROP TABLE lesson_hall');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lesson_field (lesson_id INT NOT NULL, field_id INT NOT NULL, INDEX IDX_111391DFCDF80196 (lesson_id), INDEX IDX_111391DF443707B0 (field_id), PRIMARY KEY(lesson_id, field_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE lesson_hall (lesson_id INT NOT NULL, hall_id INT NOT NULL, INDEX IDX_22FE6E5BCDF80196 (lesson_id), INDEX IDX_22FE6E5B52AFCFD6 (hall_id), PRIMARY KEY(lesson_id, hall_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE lesson_field ADD CONSTRAINT FK_111391DF443707B0 FOREIGN KEY (field_id) REFERENCES field (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_field ADD CONSTRAINT FK_111391DFCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_hall ADD CONSTRAINT FK_22FE6E5B52AFCFD6 FOREIGN KEY (hall_id) REFERENCES hall (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE lesson_hall ADD CONSTRAINT FK_22FE6E5BCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE booking_lesson');
    }
}
