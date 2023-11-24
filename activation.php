<?php
/**

    *table created on database while activation time */
#variable for create table in database
global $wpdb;
  $table_name1 = $wpdb->prefix .  'purevision_lens_material';  
  $table_name2 = $wpdb->prefix .  'purevision_lense_types';
  $table_name3 = $wpdb->prefix .  'purevision_lens_tints';  
  $table_name4 = $wpdb->prefix .  'purevision_lens_finishing';    
  $table_name5 = $wpdb->prefix .  'purevision_lens_choose';
  $table_name6 = $wpdb->prefix .  'purevision_lens_profiling'; 
  $table_name7 = $wpdb->prefix .  'profile_demos';
  $table_name8 = $wpdb->prefix .  'purevision_tint_density';

  
  #query for insert data in Database table
  
    $sql1 = "CREATE TABLE IF NOT EXISTS `".$table_name1."` (
      `lens_material_id` int(11) NOT NULL AUTO_INCREMENT,
      `lens_material_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `image` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      `price` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `coatings` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
    `recommended_coatings` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `created_on` timestamp DEFAULT current_timestamp,
      `updated_on` timestamp DEFAULT current_timestamp,
      PRIMARY KEY (`lens_material_id`) USING BTREE
      ) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
        INSERT INTO `".$table_name1."` (`lens_material_id`, `lens_material_name`,`image`, `desc`, `price`,`coatings`,`recommended_coatings`,`created_on`,`updated_on`) VALUES
        (1, '1.50 STANDARD', '', 'Standard Lens Thickness', '0.00', '1,2,3,4,5', '2',current_timestamp(), current_timestamp()),
        (2, '1.57 MID INDEX', '', 'Thinner than Standard', '1000.00', '1,2,3,4,5,6', '2',current_timestamp(), current_timestamp()),
        (3, '1.59 PC HIGH-INDEX', '', '30% Thinner than Standard', '2500', '1,2,3', '2',current_timestamp(), current_timestamp()),
        (4, '1.61 HIGH-INDEX', '', '40% Thinner than Standard', '3000.00', '1,2,3,4,6', '3',current_timestamp(), current_timestamp()),
        (5, '1.67 HIGH-INDEX', '', '50% Thinner than Standard', '1000', '2,4,5,6', '5',current_timestamp(), current_timestamp()),
        (6, '1.74 HIGH-INDEX', '', '65% Thinner than Standard', '1500.00', '1,2,6', '6',current_timestamp(), current_timestamp());";
 
        $sql2 = "CREATE TABLE IF NOT EXISTS `".$table_name2."`  (
          `lens_type_id` int(11) NOT NULL AUTO_INCREMENT,
          `lens_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
          `price` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
          `image` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
          `desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
          `show_addition` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
          `thickness` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
          `recommended_thickness` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
          `created_on` timestamp DEFAULT current_timestamp,   
          `updated_on` timestamp DEFAULT current_timestamp,
          PRIMARY KEY (`lens_type_id`) USING BTREE
          ) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
          INSERT INTO `".$table_name2."` (`lens_type_id`, `lens_name`, `price`,`image`, `desc`, `show_addition`, `thickness`, `recommended_thickness`,`created_on`,`updated_on`) VALUES
      (1, 'DISTANCE', '10','', 'General use lenses for seeing things far away', '', '1,2,3,4,5', '2', current_timestamp(), current_timestamp()),
      (2, 'MULTIFOCAL', '10','', 'Lenses for seeing things both close and far away', '', '1,2,3,4,5,6', '3', current_timestamp(), current_timestamp()),
      (3, 'READING', '10','', 'General use lenses for seeing things up close', 'yes', '1,2,3,6', '6', current_timestamp(), current_timestamp()),
      (4, 'NON-PRESCRIPTION','', '', 'Lenses without any prescription, because people who ', '', '1,2,3,4,6', '4', current_timestamp(), current_timestamp());";
      
        $sql3 = "CREATE TABLE IF NOT EXISTS `".$table_name3."` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      `price` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `color` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `created_on` timestamp DEFAULT current_timestamp,
      `updated_on` timestamp DEFAULT current_timestamp,
      PRIMARY KEY (`id`) USING BTREE
      ) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
      INSERT INTO `".$table_name3."` (`id`, `name`, `desc`, `price`, `type`, `color`,`created_on`,`updated_on`) VALUES
    (1, 'Blue', 'Blue', '10.00', 'color-tint', '#185f86',current_timestamp(), current_timestamp()),
    (2, 'Green', 'Green', '10.00', 'color-tint', '#526134',current_timestamp(), current_timestamp()),	
    (3, 'Red', 'Red', '10.00', 'color-tint', '#ae3c66',current_timestamp(), current_timestamp()),
    (4, 'Gray', 'Gray', '10.00', 'color-tint', '#4e4e4e',current_timestamp(), current_timestamp()),	
    (5, 'Brown', 'Brown', '10.00', 'color-tint', '#83582f',current_timestamp(), current_timestamp()),
    (6, 'Yellow', 'Yellow', '10.00', 'color-tint', '#948e1c',current_timestamp(), current_timestamp()),	
    (7, 'Purple', 'Purple', '10.00', 'color-tint', '#7c427b',current_timestamp(), current_timestamp());";
    

$sql4 = "CREATE TABLE IF NOT EXISTS `".$table_name4."` (
   `lens_finish_id` int(11) NOT NULL AUTO_INCREMENT,
  `lens_finish_name` varchar(255) NULL DEFAULT NULL,
  `desc` text(1000) NULL DEFAULT NULL,
  `lens_type_id` int(11) NULL DEFAULT NULL,
  `price` int(11) NULL DEFAULT NULL,
  `image` varchar(255) NULL DEFAULT NULL,
  `created_on` timestamp DEFAULT current_timestamp,
  `updated_on` timestamp DEFAULT current_timestamp,
  PRIMARY KEY (`lens_finish_id`) USING BTREE,
  FOREIGN KEY(`lens_type_id`) REFERENCES $table_name2 (`lens_type_id`) 
  ) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
   INSERT INTO `".$table_name4."` (`lens_finish_id`, `lens_finish_name`, `lens_type_id`, `desc`,`image`, `price`,`created_on`,`updated_on`) VALUES
    (1,  'Bifocal', '1','','', '',current_timestamp(), current_timestamp()),
    (2,  'Progressive' ,'1', '','','',current_timestamp(), current_timestamp()),
    (3,  'Premium Progressive','1', '','', '',current_timestamp(), current_timestamp()),
    (4,  'Tint','1', '','', '',current_timestamp(), current_timestamp()),
    (5,  'Bifocal', '2','','', '',current_timestamp(), current_timestamp()),
    (6,  'Progressive' ,'2', '','','',current_timestamp(), current_timestamp()),
    (7,  'Premium Progressive','2', '','', '',current_timestamp(), current_timestamp()),
    (8,  'Tint','2', '','', '',current_timestamp(), current_timestamp()),
    (9,  'Bifocal', '3','','', '',current_timestamp(), current_timestamp()),
    (10,  'Progressive' ,'3', '','','',current_timestamp(), current_timestamp()),
    (11,  'Premium Progressive','3', '','', '',current_timestamp(), current_timestamp()),
    (12,  'Tint','3', '','', '',current_timestamp(), current_timestamp());";

    $sql5 = "CREATE TABLE IF NOT EXISTS `".$table_name5."`(
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `lens_material_id` int(11) NULL DEFAULT NULL,
      `lens_finish_id` int(11) NULL DEFAULT NULL,
      `short_desc` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `desc` text CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
      `price` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
      `created_on` timestamp DEFAULT current_timestamp,
      `updated_on` timestamp DEFAULT current_timestamp,
      PRIMARY KEY (`id`) USING BTREE,
  FOREIGN KEY(`lens_material_id`) REFERENCES $table_name1 (`lens_material_id`) ,
  FOREIGN KEY(`lens_finish_id`) REFERENCES $table_name4 (`lens_finish_id`)  
  ) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
    INSERT INTO `".$table_name5."` (`id`, `name`,`short_desc`, `lens_material_id`,`lens_finish_id`, `desc`, `price`, `created_on`,`updated_on`) VALUES
(1, 'STANDARD', 'Premium coatings bundle','1','1',  '<b>Free Gift:</b></br>\r\nExquisite Glasses Case</br>\r\nMicrofiber Cleaning Cloth', '0.00',current_timestamp(), current_timestamp()),
(2, 'MULTI COATING', 'Premium coatings bundle','1','1', 'Hydrophobic Coating (HMC)</br>\r\nWater Resistant Coating</br>\r\nAnti-reflective</br>\r\nAnti-radiation Coating</br>\r\nUltraviolet Protection (UV)</br>\r\nHard Coating</br>\r\nOleophobic Resistant</br>\r\nScratch Resistant</br>', '10.00',current_timestamp(), current_timestamp()),
(3, 'POLARIZED', 'Premium coatings bundle', '1', '1','Polarized</br>\r\nWater Resistant Coating</br>\r\nAnti-reflective</br>\r\nAnti-radiation Coating</br>\r\nUltraviolet Protection (UV)</br>\r\nHard Coating</br>\r\nOleophobic Resistant</br>\r\nScratch Resistant</br>', '10.00',current_timestamp(), current_timestamp()),
(4, 'PHOTOCHROMIC', 'Premium coatings bundle','1','1', 'Photochromic</br>\r\nAnti-reflective</br>\r\nAnti-radiation Coating</br>\r\nUltraviolet Protection (UV)</br>\r\nHard Coating</br>\r\nOleophobic Resistant</br>\r\nScratch Resistant', '10.00',current_timestamp(), current_timestamp()),
(5, 'COMPUTER LENS', 'Premium coatings bundle','1','1', 'Hydrophobic Coating (HMC)</br>\r\nAnti-reflective</br>\r\nAnti-radiation Coating</br>\r\nUltraviolet Protection (UV)</br>\r\nHard Coating</br>\r\nOleophobic Resistant</br>\r\nScratch Resistant</br>\r\nAnti-Blue Light</br>\r\nAnti-PC Radiation', '10.00',current_timestamp(), current_timestamp()),
(6, 'ANTI-REFLECTIVE', 'Premium coatings bundle','1','1', 'Anti-reflective</br>\r\nAnti-radiation Coating</br>\r\nUltraviolet Protection (UV)</br>\r\nHard Coating</br>\r\nScratch Resistant', '10.00',current_timestamp(), current_timestamp()),
(7, 'STANDARD', 'Premium coatings bundle','2','2',  '<b>Free Gift:</b></br>\r\nExquisite Glasses Case</br>\r\nMicrofiber Cleaning Cloth', '0.00',current_timestamp(), current_timestamp()),
(8, 'MULTI COATING', 'Premium coatings bundle','2','2', 'Hydrophobic Coating (HMC)</br>\r\nWater Resistant Coating</br>\r\nAnti-reflective</br>\r\nAnti-radiation Coating</br>\r\nUltraviolet Protection (UV)</br>\r\nHard Coating</br>\r\nOleophobic Resistant</br>\r\nScratch Resistant</br>', '20.00',current_timestamp(), current_timestamp()),
(9, 'POLARIZED', 'Premium coatings bundle', '2', '2','Polarized</br>\r\nWater Resistant Coating</br>\r\nAnti-reflective</br>\r\nAnti-radiation Coating</br>\r\nUltraviolet Protection (UV)</br>\r\nHard Coating</br>\r\nOleophobic Resistant</br>\r\nScratch Resistant</br>', '20.00',current_timestamp(), current_timestamp()),
(10, 'PHOTOCHROMIC', 'Premium coatings bundle','2','2', 'Photochromic</br>\r\nAnti-reflective</br>\r\nAnti-radiation Coating</br>\r\nUltraviolet Protection (UV)</br>\r\nHard Coating</br>\r\nOleophobic Resistant</br>\r\nScratch Resistant', '20.00',current_timestamp(), current_timestamp()),
(11, 'COMPUTER LENS', 'Premium coatings bundle','2','2', 'Hydrophobic Coating (HMC)</br>\r\nAnti-reflective</br>\r\nAnti-radiation Coating</br>\r\nUltraviolet Protection (UV)</br>\r\nHard Coating</br>\r\nOleophobic Resistant</br>\r\nScratch Resistant</br>\r\nAnti-Blue Light</br>\r\nAnti-PC Radiation', '20.00',current_timestamp(), current_timestamp()),
(12, 'ANTI-REFLECTIVE', 'Premium coatings bundle','2','2', 'Anti-reflective</br>\r\nAnti-radiation Coating</br>\r\nUltraviolet Protection (UV)</br>\r\nHard Coating</br>\r\nScratch Resistant', '10.00',current_timestamp(), current_timestamp());";

$sql6 = "CREATE TABLE IF NOT EXISTS `".$table_name6."`(
  `profile_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_name` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `glass_type` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
  `lens_type_id` int(11) NULL DEFAULT NULL,
  `id` int(11) NULL DEFAULT NULL,
  `lens_material_id` int(11) NULL DEFAULT NULL,
  `lens_finish_id` int(11) NULL DEFAULT NULL,
  `created_on` timestamp DEFAULT current_timestamp,
  `updated_on` timestamp DEFAULT current_timestamp,
  PRIMARY KEY (`profile_id`) USING BTREE,
FOREIGN KEY(`lens_material_id`) REFERENCES $table_name1 (`lens_material_id`) ,
FOREIGN KEY(`lens_finish_id`) REFERENCES $table_name4 (`lens_finish_id`) ,
FOREIGN KEY(`lens_type_id`) REFERENCES $table_name2 (`lens_type_id`) ,
FOREIGN KEY(`id`) REFERENCES $table_name5 (`id`)  
) ENGINE = InnoDB CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Compact;
INSERT INTO `".$table_name6."` (`profile_id`, `profile_name`,`glass_type`,`lens_type_id`,`id`, `lens_material_id`,`lens_finish_id`, `created_on`,`updated_on`) VALUES
('1', 'Sun_test' ,'Sun Glass','1','1','1','3',current_timestamp(),current_timestamp()),
('2', 'Sun_test' ,'Sun Glass','1','1','1','4',current_timestamp(),current_timestamp());";

$sql7 = "CREATE TABLE IF NOT EXISTS `".$table_name7."`(
  `demo_id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `profile_name` varchar(255) NOT NULL,
  `glass_type` varchar(255) NOT NULL,
  `lens_type_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `lens_material_id` int(11) NOT NULL,
  `lens_finish_id` varchar(255) NOT NULL,
  PRIMARY KEY (`demo_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO `".$table_name7."` (`demo_id`, `profile_id`, `profile_name`, `glass_type`, `lens_type_id`, `id`, `lens_material_id`, `lens_finish_id`) VALUES
(1, 1, 'Sun_test', 'Sun Glass', 1, 1, 1, '3,4');";


$sql8 = "CREATE TABLE IF NOT EXISTS `".$table_name8."`(
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `percentage` varchar(255) NOT NULL,
  `text` varchar(255) NOT NULL,
  `others` varchar(255) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
INSERT INTO `".$table_name8."` (`id`, `percentage`, `text`, `others`) VALUES
(1, 40, 'Dark sunglass tint (40%)', '40');";
  require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
  dbDelta($sql1);
  dbDelta($sql2);
  dbDelta($sql3);
  dbDelta($sql4);
  dbDelta($sql5);
  dbDelta($sql6);
  dbDelta($sql7);
  dbDelta($sql8);
