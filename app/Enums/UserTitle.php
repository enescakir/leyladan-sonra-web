<?php

namespace App\Enums;

class UserTitle extends BaseEnum
{
  const All                 = 'Herkes';
  const Admin               = 'Yönetici';
  const FacultyManager      = 'Fakülte Sorumlusu';
  const FacultyBoardMember  = 'Fakülte Yönetim Kurulu';
  const CommunicationMember = 'İletişim Sorumlusu';
  const GiftMember          = 'Hediye Sorumlusu';
  const WebsiteMember       = 'Site Sorumlusu';
  const NormalMember        = 'Normal Üye';
  const BloodMember         = 'Kan Bağışı Görevlisi';
}
