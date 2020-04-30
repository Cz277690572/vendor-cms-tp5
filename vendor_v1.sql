/*
 Navicat Premium Data Transfer

 Source Server         : windows-Localhost
 Source Server Type    : MySQL
 Source Server Version : 100138
 Source Host           : 127.0.0.1:3306
 Source Schema         : vendor

 Target Server Type    : MySQL
 Target Server Version : 100138
 File Encoding         : 65001

 Date: 30/04/2020 17:23:51
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for banner
-- ----------------------------
DROP TABLE IF EXISTS `banner`;
CREATE TABLE `banner`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Banner名称，通常作为标识',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT 'Banner描述',
  `delete_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'banner管理表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of banner
-- ----------------------------
INSERT INTO `banner` VALUES (1, '首页置顶', '首页轮播图', NULL, 1586447456);

-- ----------------------------
-- Table structure for banner_item
-- ----------------------------
DROP TABLE IF EXISTS `banner_item`;
CREATE TABLE `banner_item`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '外键，关联image表',
  `key_word` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '执行关键字，根据不同的type含义不同',
  `type` tinyint(4) NOT NULL DEFAULT 1 COMMENT '跳转类型，可能导向商品，可能导向专题，可能导向其他。0，无导向；1：导向商品;2:导向专题',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '销售状态。0，未上线；1，已上线',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序权重',
  `delete_time` int(11) NULL DEFAULT NULL,
  `banner_id` bigint(20) NOT NULL COMMENT '外键，关联banner表',
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6866002307 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = 'banner子项表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of banner_item
-- ----------------------------
INSERT INTO `banner_item` VALUES (1, 65, '6', 1, 1, 0, NULL, 1, NULL);
INSERT INTO `banner_item` VALUES (2, 2, '25', 1, 1, 0, NULL, 1, NULL);
INSERT INTO `banner_item` VALUES (3, 3, '11', 1, 1, 0, NULL, 1, NULL);
INSERT INTO `banner_item` VALUES (5, 1, '10', 1, 1, 0, NULL, 1, 1586704256);
INSERT INTO `banner_item` VALUES (6866002306, 166, '17', 1, 0, 0, 1588237281, 1, 1588237281);

-- ----------------------------
-- Table structure for category
-- ----------------------------
DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '分类名称',
  `topic_img_id` int(11) NULL DEFAULT NULL COMMENT '外键，关联image表',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '销售状态。0，未上线；1，已上线',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序权重',
  `delete_time` int(11) NULL DEFAULT NULL,
  `description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '描述',
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 17 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '商品类目' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of category
-- ----------------------------
INSERT INTO `category` VALUES (2, '果味', 6, 1, 0, NULL, NULL, NULL);
INSERT INTO `category` VALUES (3, '蔬菜', 5, 1, 0, NULL, NULL, NULL);
INSERT INTO `category` VALUES (4, '炒货', 7, 1, 0, NULL, NULL, NULL);
INSERT INTO `category` VALUES (5, '点心', 4, 1, 0, NULL, NULL, NULL);
INSERT INTO `category` VALUES (6, '粗茶', 8, 1, 9, NULL, '', 1585925065);
INSERT INTO `category` VALUES (7, '淡饭', 9, 1, 8, NULL, NULL, NULL);
INSERT INTO `category` VALUES (10, '春意', 71, 1, 10, 1585673848, 'xxx', NULL);
INSERT INTO `category` VALUES (11, 'xxx', 72, 1, 0, 1585673999, 'dddd', NULL);
INSERT INTO `category` VALUES (12, 'ffff', 73, 1, 0, 1585673994, 'gggg', 1585673026);
INSERT INTO `category` VALUES (13, 'ggg', 74, 1, 1, 1585673985, '', 1585673185);
INSERT INTO `category` VALUES (14, '111', 75, 1, 0, 1585673990, '', 1585673198);
INSERT INTO `category` VALUES (15, '頂頂頂頂', 76, 1, 1, 1585755304, '', 1585755181);
INSERT INTO `category` VALUES (16, 'test111', 139, 0, 11, 1588237270, 'ddd', 1586608508);

-- ----------------------------
-- Table structure for express_company
-- ----------------------------
DROP TABLE IF EXISTS `express_company`;
CREATE TABLE `express_company`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `express_title` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司名称',
  `express_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司代码',
  `express_desc` varchar(512) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT '' COMMENT '快递公司描述',
  `status` tinyint(1) UNSIGNED NULL DEFAULT 1 COMMENT '状态(0.无效,1.有效)',
  `sort` bigint(20) UNSIGNED NULL DEFAULT 0 COMMENT '排序权重',
  `delete_time` int(11) NULL DEFAULT NULL,
  `create_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 95 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '快递-公司' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of express_company
-- ----------------------------
INSERT INTO `express_company` VALUES (5, 'AAE全球专递', 'aae', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (6, '安捷快递', 'anjie', '', 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (7, '安信达快递', 'anxindakuaixi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (8, '彪记快递', 'biaojikuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (9, 'BHT', 'bht', '', 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (10, '百福东方国际物流', 'baifudongfang', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (11, '中国东方（COE）', 'coe', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (12, '长宇物流', 'changyuwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (13, '大田物流', 'datianwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (14, '德邦物流', 'debangwuliu', '', 1, 1, NULL, NULL);
INSERT INTO `express_company` VALUES (15, 'DHL', 'dhl', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (16, 'DPEX', 'dpex', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (17, 'd速快递', 'dsukuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (18, '递四方', 'disifang', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (19, 'EMS快递', 'ems', '', 1, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (20, 'FEDEX（国外）', 'fedex', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (21, '飞康达物流', 'feikangda', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (22, '凤凰快递', 'fenghuangkuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (23, '飞快达', 'feikuaida', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (24, '国通快递', 'guotongkuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (25, '港中能达物流', 'ganzhongnengda', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (26, '广东邮政物流', 'guangdongyouzhengwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (27, '共速达', 'gongsuda', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (28, '汇通快运', 'huitongkuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (29, '恒路物流', 'hengluwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (30, '华夏龙物流', 'huaxialongwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (31, '海红', 'haihongwangsong', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (32, '海外环球', 'haiwaihuanqiu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (33, '佳怡物流', 'jiayiwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (34, '京广速递', 'jinguangsudikuaijian', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (35, '急先达', 'jixianda', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (36, '佳吉物流', 'jjwl', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (37, '加运美物流', 'jymwl', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (38, '金大物流', 'jindawuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (39, '嘉里大通', 'jialidatong', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (40, '晋越快递', 'jykd', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (41, '快捷速递', 'kuaijiesudi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (42, '联邦快递（国内）', 'lianb', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (43, '联昊通物流', 'lianhaowuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (44, '龙邦物流', 'longbanwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (45, '立即送', 'lijisong', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (46, '乐捷递', 'lejiedi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (47, '民航快递', 'minghangkuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (48, '美国快递', 'meiguokuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (49, '门对门', 'menduimen', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (50, 'OCS', 'ocs', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (51, '配思货运', 'peisihuoyunkuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (52, '全晨快递', 'quanchenkuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (53, '全峰快递', 'quanfengkuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (54, '全际通物流', 'quanjitong', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (55, '全日通快递', 'quanritongkuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (56, '全一快递', 'quanyikuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (57, '如风达', 'rufengda', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (58, '三态速递', 'santaisudi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (59, '盛辉物流', 'shenghuiwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (60, '申通', 'shentong', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (61, '顺丰', 'shunfeng', '', 1, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (62, '速尔物流', 'sue', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (63, '盛丰物流', 'shengfeng', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (64, '赛澳递', 'saiaodi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (65, '天地华宇', 'tiandihuayu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (66, '天天快递', 'tiantian', NULL, 1, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (67, 'TNT', 'tnt', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (68, 'UPS', 'ups', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (69, '万家物流', 'wanjiawuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (70, '文捷航空速递', 'wenjiesudi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (71, '伍圆', 'wuyuan', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (72, '万象物流', 'wxwl', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (73, '新邦物流', 'xinbangwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (74, '信丰物流', 'xinfengwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (75, '亚风速递', 'yafengsudi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (76, '一邦速递', 'yibangwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (77, '优速物流', 'youshuwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (78, '邮政包裹挂号信', 'youzhengguonei', NULL, 0, 3, NULL, NULL);
INSERT INTO `express_company` VALUES (79, '邮政国际包裹挂号信', 'youzhengguoji', NULL, 0, 2, NULL, NULL);
INSERT INTO `express_company` VALUES (80, '远成物流', 'yuanchengwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (81, '圆通速递', 'yuantong', '', 1, 1, NULL, NULL);
INSERT INTO `express_company` VALUES (82, '源伟丰快递', 'yuanweifeng', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (83, '元智捷诚快递', 'yuanzhijiecheng', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (84, '韵达快运', 'yunda', NULL, 1, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (85, '运通快递', 'yuntongkuaidi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (86, '越丰物流', 'yuefengwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (87, '源安达', 'yad', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (88, '银捷速递', 'yinjiesudi', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (89, '宅急送', 'zhaijisong', NULL, 1, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (90, '中铁快运', 'zhongtiekuaiyun', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (91, '中通速递', 'zhongtong', '', 1, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (92, '中邮物流', 'zhongyouwuliu', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (93, '忠信达', 'zhongxinda', NULL, 0, 0, NULL, NULL);
INSERT INTO `express_company` VALUES (94, '芝麻开门', 'zhimakaimen', '', 0, 0, NULL, NULL);

-- ----------------------------
-- Table structure for image
-- ----------------------------
DROP TABLE IF EXISTS `image`;
CREATE TABLE `image`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '图片路径',
  `from` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1 来自本地，2 来自公网',
  `delete_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 200 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '图片总表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of image
-- ----------------------------
INSERT INTO `image` VALUES (1, '/banner-1a.png', 1, NULL, 1586704256);
INSERT INTO `image` VALUES (2, '/banner-2a.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (3, '/banner-3a.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (4, '/category-cake.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (5, '/category-vg.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (6, '/category-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (7, '/category-fry-a.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (8, '/a4d604d4cb305851/b96a161440e4a640.png', 1, NULL, 1585925065);
INSERT INTO `image` VALUES (9, '/category-rice.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (14, '/product-rice@6.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (16, '/ff75da8d60a412fb/441fcc78976e3a2a.png', 1, NULL, 1587953008);
INSERT INTO `image` VALUES (17, '/2@theme.png', 1, NULL, 1587898328);
INSERT INTO `image` VALUES (18, '/3@theme.png', 1, NULL, 1588155698);
INSERT INTO `image` VALUES (19, '/detail-1@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (20, '/detail-2@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (21, '/detail-3@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (22, '/detail-4@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (23, '/detail-5@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (24, '/detail-6@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (25, '/detail-7@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (26, '/detail-8@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (27, '/detail-9@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (28, '/detail-11@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (29, '/detail-10@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (31, '/product-rice@1.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (36, '/product-dryfruit@3.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (37, '/product-dryfruit@4.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (39, '/product-dryfruit-a@6.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (41, '/product-rice@2.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (42, '/product-rice@3.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (43, '/product-rice@4.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (44, '/product-fry@1.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (45, '/product-fry@2.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (46, '/product-fry@3.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (47, '/product-tea@2.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (48, '/product-tea@3.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (49, '/1@theme-head.png', 1, NULL, 1587953008);
INSERT INTO `image` VALUES (50, '/652cb7a7217aa9b1/9ea7c600f1a323c9.png', 1, NULL, 1587898328);
INSERT INTO `image` VALUES (51, '/3@theme-head.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (52, '/product-cake@1.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (53, '/product-cake@2.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (54, '/product-cake-a@3.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (55, '/product-cake-a@4.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (56, '/product-dryfruit@8.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (57, '/product-fry@4.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (58, '/product-fry@5.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (59, '/product-rice@5.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (60, '/product-rice@7.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (62, '/detail-12@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (63, '/detail-13@1-dryfruit.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (65, '/banner-4a.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (66, '/product-vg@4.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (67, '/product-vg@5.png', 1, NULL, NULL);
INSERT INTO `image` VALUES (71, '/49eacdbb3bbf8383/85e9d9befaf802ba.jpg', 1, NULL, 1585672873);
INSERT INTO `image` VALUES (72, '/49eacdbb3bbf8383/85e9d9befaf802ba.jpg', 1, NULL, 1585672925);
INSERT INTO `image` VALUES (73, '/49eacdbb3bbf8383/85e9d9befaf802ba.jpg', 1, NULL, 1585673026);
INSERT INTO `image` VALUES (74, '/49eacdbb3bbf8383/85e9d9befaf802ba.jpg', 1, NULL, 1585673185);
INSERT INTO `image` VALUES (75, '/49eacdbb3bbf8383/85e9d9befaf802ba.jpg', 1, NULL, 1585673198);
INSERT INTO `image` VALUES (139, '/5037bffcdf09bc7c/b5261a08189ea4be.png', 1, 1588237270, 1586608508);
INSERT INTO `image` VALUES (161, '/5037bffcdf09bc7c/b5261a08189ea4be.png', 1, 1587210485, 1585937785);
INSERT INTO `image` VALUES (162, '/92e953fad71f84b6/7c463eeddd5606ee.png', 1, 1587210485, 1585937785);
INSERT INTO `image` VALUES (166, '/5037bffcdf09bc7c/b5261a08189ea4be.png', 1, 1588237281, 1588237281);
INSERT INTO `image` VALUES (168, '/product-dryfruit@7.png', 1, NULL, 1586607214);
INSERT INTO `image` VALUES (170, '/product-dryfruit@1.png', 1, NULL, 1586607454);
INSERT INTO `image` VALUES (174, '/92e953fad71f84b6/7c463eeddd5606ee.png', 1, 1587210480, 1586607786);
INSERT INTO `image` VALUES (175, '/92e953fad71f84b6/7c463eeddd5606ee.png', 1, 1587210476, 1586607893);
INSERT INTO `image` VALUES (178, '/product-vg@1.png', 1, NULL, 1586669342);
INSERT INTO `image` VALUES (186, '/product-vg@2.png', 1, NULL, 1586673207);
INSERT INTO `image` VALUES (187, '/product-dryfruit@2.png', 1, NULL, 1587233948);
INSERT INTO `image` VALUES (188, '/product-tea@1.png', 1, NULL, 1587235718);
INSERT INTO `image` VALUES (191, '/product-dryfruit@5.png', 1, NULL, 1587236399);
INSERT INTO `image` VALUES (198, '/product-vg@3.png', 1, NULL, 1588153171);
INSERT INTO `image` VALUES (199, '/43d42e4d0789ac30/7e043290147b7dc6.png', 1, NULL, 1588153171);

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '订单号',
  `user_id` int(11) NOT NULL COMMENT '外键，用户id，注意并不是openid',
  `delete_time` int(11) NULL DEFAULT NULL,
  `create_time` int(11) NULL DEFAULT NULL,
  `total_price` decimal(20, 2) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '1:未支付， 2:已支付，3:已发货 , 4:已支付，但库存不足, 5:已完成, 6:已取消',
  `snap_img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单快照图片',
  `snap_name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单快照名称',
  `total_count` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NULL DEFAULT NULL,
  `snap_items` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL COMMENT '订单其他信息快照（json)',
  `snap_address` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '地址快照',
  `prepay_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '订单微信支付的预订单id（用于发送模板消息）',
  `express_company_code` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '发货快递公司编码',
  `express_company_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '发货快递公司名称',
  `express_send_no` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '发货单号',
  `express_send_time` int(11) NULL DEFAULT NULL COMMENT '发货时间',
  `express_price` decimal(20, 2) NULL DEFAULT 0.00 COMMENT '快递费用',
  `pay_price` decimal(20, 2) NOT NULL DEFAULT 0.00 COMMENT '支付金额',
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `order_no`(`order_no`) USING BTREE,
  INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 565 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order
-- ----------------------------
INSERT INTO `order` VALUES (539, 'D412238306382049', 58, NULL, 1586623830, 0.01, 1, 'http://vendor.cn/upload/product-vg@2.png', '泥蒿 半斤', 1, 1586623830, '[{\"id\":7,\"haveStock\":true,\"counts\":\"1\",\"price\":\"0.01\",\"name\":\"\\u6ce5\\u84bf \\u534a\\u65a4\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-vg@2.png\"}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00);
INSERT INTO `order` VALUES (540, 'D412272636757858', 58, NULL, 1586627263, 0.01, 1, 'http://vendor.cn/upload/product-rice@1.png', '素米 327克', 1, 1586627263, '[{\"id\":3,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u7d20\\u7c73 327\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-rice@1.png\"}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00);
INSERT INTO `order` VALUES (541, 'D412277427986625', 58, NULL, 1586627742, 10.00, 1, 'http://vendor.cn/upload/5037bffcdf09bc7c/b5261a08189ea4be.png', '濑尿虾寿司 100给', 1, 1586627742, '[{\"id\":6859225246,\"haveStock\":true,\"counts\":1,\"price\":\"10.00\",\"name\":\"\\u6fd1\\u5c3f\\u867e\\u5bff\\u53f8 100\\u7ed9\",\"totalPrice\":10,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/5037bffcdf09bc7c\\/b5261a08189ea4be.png\"}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00);
INSERT INTO `order` VALUES (542, 'D412282278117526', 58, NULL, 1586628227, 0.01, 1, 'http://vendor.cn/upload/product-fry@3.png', '碧水葵花籽 128克', 1, 1586628227, '[{\"id\":19,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u78a7\\u6c34\\u8475\\u82b1\\u7c7d 128\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-fry@3.png\"}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00);
INSERT INTO `order` VALUES (543, 'D412629597303403', 58, NULL, 1586662959, 0.01, 1, 'http://vendor.cn/upload/product-vg@2.png', '泥蒿 半斤', 1, 1586662959, '[{\"id\":7,\"haveStock\":true,\"counts\":\"1\",\"price\":\"0.01\",\"name\":\"\\u6ce5\\u84bf \\u534a\\u65a4\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-vg@2.png\"}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00);
INSERT INTO `order` VALUES (544, 'D412629695899816', 58, NULL, 1586662969, 0.01, 1, 'http://vendor.cn/upload/product-vg@2.png', '泥蒿 半斤', 1, 1586662969, '[{\"id\":7,\"haveStock\":true,\"counts\":\"1\",\"price\":\"0.01\",\"name\":\"\\u6ce5\\u84bf \\u534a\\u65a4\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-vg@2.png\"}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00);
INSERT INTO `order` VALUES (545, 'D412629727784588', 58, NULL, 1586662972, 0.01, 1, 'http://vendor.cn/upload/product-vg@2.png', '泥蒿 半斤', 1, 1586662972, '[{\"id\":7,\"haveStock\":true,\"counts\":\"1\",\"price\":\"0.01\",\"name\":\"\\u6ce5\\u84bf \\u534a\\u65a4\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-vg@2.png\"}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00);
INSERT INTO `order` VALUES (546, 'D412697938307184', 58, NULL, 1586669793, 0.01, 1, 'http://vendor.cn/upload/product-vg@2.png', '泥蒿 半斤', 1, 1586669793, '[{\"id\":7,\"haveStock\":true,\"counts\":\"1\",\"price\":\"0.01\",\"name\":\"\\u6ce5\\u84bf \\u534a\\u65a4\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-vg@2.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00);
INSERT INTO `order` VALUES (547, 'D412710423963905', 58, NULL, 1586671042, 0.01, 1, 'http://vendor.cn/upload/product-vg@2.png', '泥蒿 半斤', 1, 1586671042, '[{\"id\":7,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u6ce5\\u84bf \\u534a\\u65a4\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-vg@2.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00);
INSERT INTO `order` VALUES (548, 'D412713217829641', 58, NULL, 1586671321, 0.01, 3, 'http://vendor.cn/upload/product-rice@1.png', '素米 327克', 1, 1586967974, '[{\"id\":3,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u7d20\\u7c73 327\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-rice@1.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586967974}', NULL, 'zhongtong', '中通速递', '75331105617706', 1586967974, 0.00, 0.00);
INSERT INTO `order` VALUES (549, 'D412715756422202', 58, NULL, 1586671575, 0.01, 3, 'http://vendor.cn/upload/product-dryfruit@2.png', '春生龙眼 500克', 1, 1586705504, '[{\"id\":5,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u6625\\u751f\\u9f99\\u773c 500\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-dryfruit@2.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', '999999999', 'zhongtong', '中通速递', '75331105617706', 1586967974, 0.00, 0.00);
INSERT INTO `order` VALUES (550, 'D419299148239984', 58, NULL, 1587229914, 0.43, 1, 'http://vendor.cn/upload/product-tea@1.png', '红袖枸杞 6克*3袋', 43, 1587229914, '[{\"id\":4,\"haveStock\":true,\"counts\":43,\"price\":\"0.01\",\"name\":\"\\u7ea2\\u8896\\u67b8\\u675e 6\\u514b*3\\u888b\",\"totalPrice\":0.43,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-tea@1.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 0.00, 0.00);
INSERT INTO `order` VALUES (551, 'D419315733126051', 58, NULL, 1587231573, 0.03, 1, 'http://vendor.cn/upload/product-dryfruit@2.png', '春生龙眼 500克', 3, 1587231573, '[{\"id\":5,\"haveStock\":true,\"counts\":3,\"price\":\"0.01\",\"name\":\"\\u6625\\u751f\\u9f99\\u773c 500\\u514b\",\"totalPrice\":0.03,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-dryfruit@2.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.03);
INSERT INTO `order` VALUES (552, 'D419347984136208', 58, NULL, 1587234798, 0.10, 1, 'http://vendor.cn/upload/product-dryfruit@2.png', '春生龙眼 500克', 1, 1587234798, '[{\"id\":5,\"haveStock\":true,\"counts\":1,\"price\":\"0.10\",\"name\":\"\\u6625\\u751f\\u9f99\\u773c 500\\u514b\",\"totalPrice\":0.1,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-dryfruit@2.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.10);
INSERT INTO `order` VALUES (553, 'D419348362065799', 58, NULL, 1587234836, 0.01, 1, 'http://vendor.cn/upload/product-rice@1.png', '素米 327克', 1, 1587234836, '[{\"id\":3,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u7d20\\u7c73 327\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-rice@1.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.01);
INSERT INTO `order` VALUES (554, 'D419349665922132', 58, NULL, 1587234966, 0.01, 1, 'http://vendor.cn/upload/product-rice@1.png', '素米 327克', 1, 1587234966, '[{\"id\":3,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u7d20\\u7c73 327\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-rice@1.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.01);
INSERT INTO `order` VALUES (555, 'D419352200962244', 58, NULL, 1587235220, 0.01, 1, 'http://vendor.cn/upload/product-rice@1.png', '素米 327克', 1, 1587235220, '[{\"id\":3,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u7d20\\u7c73 327\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-rice@1.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.01);
INSERT INTO `order` VALUES (556, 'D419352861092919', 58, NULL, 1587235286, 0.01, 1, 'http://vendor.cn/upload/product-rice@1.png', '素米 327克', 1, 1587235286, '[{\"id\":3,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u7d20\\u7c73 327\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-rice@1.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.01);
INSERT INTO `order` VALUES (557, 'D419356411931441', 58, NULL, 1587235641, 0.01, 1, 'http://vendor.cn/upload/product-tea@1.png', '红袖枸杞 6克*3袋', 1, 1587235641, '[{\"id\":4,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u7ea2\\u8896\\u67b8\\u675e 6\\u514b*3\\u888b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-tea@1.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.01);
INSERT INTO `order` VALUES (558, 'D419361798560135', 58, NULL, 1587236179, 0.01, 1, 'http://vendor.cn/upload/product-dryfruit@5.png', '万紫千凤梨 300克', 1, 1587236179, '[{\"id\":10,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u4e07\\u7d2b\\u5343\\u51e4\\u68a8 300\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-dryfruit@5.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.01);
INSERT INTO `order` VALUES (559, 'D419626228617897', 58, NULL, 1587262622, 0.01, 3, 'http://vendor.cn/upload/product-dryfruit@7.png', '珍奇异果 3个', 1, 1587374551, '[{\"id\":12,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u73cd\\u5947\\u5f02\\u679c 3\\u4e2a\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-dryfruit@7.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1587374551}', NULL, 'zhongtong', '中通速递', '111111111111111', 1587374551, 10.00, 10.01);
INSERT INTO `order` VALUES (560, 'D419948208220863', 58, NULL, 1587294820, 0.08, 1, 'http://vendor.cn/upload/product-cake@2.png', '小红的猪耳朵 120克等', 8, 1587294820, '[{\"id\":8,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u590f\\u65e5\\u8292\\u679c 3\\u4e2a\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-dryfruit@3.png\",\"delete_time\":null,\"status\":1},{\"id\":6,\"haveStock\":true,\"counts\":7,\"price\":\"0.01\",\"name\":\"\\u5c0f\\u7ea2\\u7684\\u732a\\u8033\\u6735 120\\u514b\",\"totalPrice\":0.07,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-cake@2.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.08);
INSERT INTO `order` VALUES (561, 'D419036495488626', 58, NULL, 1587303649, 0.01, 1, 'http://vendor.cn/upload/product-dryfruit-a@6.png', '贵妃笑 100克', 1, 1587303649, '[{\"id\":11,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u8d35\\u5983\\u7b11 100\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-dryfruit-a@6.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.01);
INSERT INTO `order` VALUES (562, 'D419115435859913', 58, NULL, 1587311543, 0.01, 1, 'http://vendor.cn/upload/product-fry@1.png', '油炸花生 300克', 1, 1587311543, '[{\"id\":17,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u6cb9\\u70b8\\u82b1\\u751f 300\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-fry@1.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.01);
INSERT INTO `order` VALUES (563, 'D419115949299141', 58, NULL, 1587311594, 0.01, 1, 'http://vendor.cn/upload/product-fry@3.png', '碧水葵花籽 128克', 1, 1587311594, '[{\"id\":19,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u78a7\\u6c34\\u8475\\u82b1\\u7c7d 128\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-fry@3.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.01);
INSERT INTO `order` VALUES (564, 'D427856715075005', 58, NULL, 1587985671, 0.01, 1, 'http://vendor.cn/upload/product-dryfruit@5.png', '万紫千凤梨 300克', 1, 1587985671, '[{\"id\":10,\"haveStock\":true,\"counts\":1,\"price\":\"0.01\",\"name\":\"\\u4e07\\u7d2b\\u5343\\u51e4\\u68a8 300\\u514b\",\"totalPrice\":0.01,\"main_img_url\":\"http:\\/\\/vendor.cn\\/upload\\/product-dryfruit@5.png\",\"delete_time\":null,\"status\":1}]', '{\"name\":\"levi\",\"mobile\":\"15220501265\",\"province\":\"\\u5e7f\\u4e1c\\u7701\",\"city\":\"\\u6df1\\u5733\\u5e02\",\"country\":\"\\u5b9d\\u5b89\\u533a\",\"detail\":\"\\u65b0\\u5c4b\\u56ed2\\u5df73\\u53f7\",\"update_time\":1586622551}', NULL, NULL, NULL, NULL, NULL, 10.00, 10.01);

-- ----------------------------
-- Table structure for order_product
-- ----------------------------
DROP TABLE IF EXISTS `order_product`;
CREATE TABLE `order_product`  (
  `order_id` int(11) NOT NULL COMMENT '联合主键，订单id',
  `product_id` bigint(20) NOT NULL COMMENT '联合主键，商品id',
  `count` int(11) NOT NULL COMMENT '商品数量',
  `delete_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`product_id`, `order_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of order_product
-- ----------------------------
INSERT INTO `order_product` VALUES (540, 3, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (548, 3, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (553, 3, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (554, 3, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (555, 3, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (556, 3, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (550, 4, 43, NULL, NULL);
INSERT INTO `order_product` VALUES (557, 4, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (549, 5, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (551, 5, 3, NULL, NULL);
INSERT INTO `order_product` VALUES (552, 5, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (560, 6, 7, NULL, NULL);
INSERT INTO `order_product` VALUES (539, 7, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (543, 7, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (544, 7, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (545, 7, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (546, 7, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (547, 7, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (560, 8, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (558, 10, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (564, 10, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (561, 11, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (559, 12, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (562, 17, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (542, 19, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (563, 19, 1, NULL, NULL);
INSERT INTO `order_product` VALUES (541, 6859225246, 1, NULL, NULL);

-- ----------------------------
-- Table structure for product
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '商品名称',
  `price` decimal(6, 2) NOT NULL COMMENT '价格,单位：分',
  `stock` int(11) NOT NULL DEFAULT 0 COMMENT '库存量',
  `delete_time` int(11) NULL DEFAULT NULL,
  `category_id` int(11) NULL DEFAULT NULL,
  `main_img_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '主图ID号，这是一个反范式设计，有一定的冗余',
  `from` tinyint(4) NOT NULL DEFAULT 1 COMMENT '图片来自 1 本地 ，2公网',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '销售状态。0，未上线；1，已上线',
  `sort` int(11) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序权重',
  `create_time` int(11) NULL DEFAULT NULL COMMENT '创建时间',
  `update_time` int(11) NULL DEFAULT NULL,
  `summary` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '摘要',
  `img_id` int(11) NULL DEFAULT NULL COMMENT '图片外键',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6866078549 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES (1, '芹菜 半斤', 0.01, 998, NULL, 3, '/product-vg@1.png', 1, 0, 0, NULL, 1586669342, '', 178);
INSERT INTO `product` VALUES (2, '梨花带雨 3个', 0.01, 984, NULL, 2, '/product-dryfruit@1.png', 1, 0, 0, NULL, 1586607454, '', 170);
INSERT INTO `product` VALUES (3, '素米 327克', 0.01, 996, NULL, 7, '/product-rice@1.png', 1, 1, 0, NULL, NULL, NULL, 31);
INSERT INTO `product` VALUES (4, '红袖枸杞 6克*3袋', 0.01, 998, NULL, 6, '/product-tea@1.png', 1, 0, 0, NULL, 1587235718, '', 188);
INSERT INTO `product` VALUES (5, '春生龙眼 500克', 0.10, 995, NULL, 2, '/product-dryfruit@2.png', 1, 1, 0, NULL, 1587233948, '', 187);
INSERT INTO `product` VALUES (6, '小红的猪耳朵 120克', 0.01, 997, NULL, 5, '/product-cake@2.png', 1, 1, 0, NULL, NULL, NULL, 53);
INSERT INTO `product` VALUES (7, '泥蒿 半斤', 0.01, 998, NULL, 3, '/product-vg@2.png', 1, 0, 0, 1586607454, 1586673207, '', 186);
INSERT INTO `product` VALUES (8, '夏日芒果 3个', 0.01, 995, NULL, 2, '/product-dryfruit@3.png', 1, 1, 0, NULL, NULL, NULL, 36);
INSERT INTO `product` VALUES (9, '冬木红枣 500克', 0.01, 996, NULL, 2, '/product-dryfruit@4.png', 1, 1, 0, NULL, NULL, NULL, 37);
INSERT INTO `product` VALUES (10, '万紫千凤梨 300克', 0.01, 996, NULL, 2, '/product-dryfruit@5.png', 1, 1, 0, NULL, 1587236399, '', 191);
INSERT INTO `product` VALUES (11, '贵妃笑 100克', 0.01, 994, NULL, 2, '/product-dryfruit-a@6.png', 1, 1, 0, NULL, NULL, NULL, 39);
INSERT INTO `product` VALUES (12, '珍奇异果 3个', 0.01, 999, NULL, 2, '/product-dryfruit@7.png', 1, 1, 0, NULL, 1586607214, '', 168);
INSERT INTO `product` VALUES (13, '绿豆 125克', 0.01, 999, NULL, 7, '/product-rice@2.png', 1, 1, 0, NULL, NULL, NULL, 41);
INSERT INTO `product` VALUES (14, '芝麻 50克', 0.01, 999, NULL, 7, '/product-rice@3.png', 1, 1, 0, NULL, NULL, NULL, 42);
INSERT INTO `product` VALUES (15, '猴头菇 370克', 0.01, 999, NULL, 7, '/product-rice@4.png', 1, 1, 0, NULL, NULL, NULL, 43);
INSERT INTO `product` VALUES (16, '西红柿 1斤', 0.01, 999, NULL, 3, '/product-vg@3.png', 1, 1, 100, NULL, 1588153171, '', 198);
INSERT INTO `product` VALUES (17, '油炸花生 300克', 0.01, 999, NULL, 4, '/product-fry@1.png', 1, 1, 0, NULL, NULL, NULL, 44);
INSERT INTO `product` VALUES (18, '春泥西瓜子 128克', 0.01, 997, NULL, 4, '/product-fry@2.png', 1, 1, 0, NULL, NULL, NULL, 45);
INSERT INTO `product` VALUES (19, '碧水葵花籽 128克', 0.01, 999, NULL, 4, '/product-fry@3.png', 1, 1, 0, NULL, NULL, NULL, 46);
INSERT INTO `product` VALUES (20, '碧螺春 12克*3袋', 0.01, 999, NULL, 6, '/product-tea@2.png', 1, 1, 0, NULL, NULL, NULL, 47);
INSERT INTO `product` VALUES (21, '西湖龙井 8克*3袋', 0.01, 998, NULL, 6, '/product-tea@3.png', 1, 1, 0, NULL, NULL, NULL, 48);
INSERT INTO `product` VALUES (22, '梅兰清花糕 1个', 0.01, 997, NULL, 5, '/product-cake-a@3.png', 1, 1, 0, NULL, NULL, NULL, 54);
INSERT INTO `product` VALUES (23, '清凉薄荷糕 1个', 0.01, 998, NULL, 5, '/product-cake-a@4.png', 1, 1, 0, NULL, NULL, NULL, 55);
INSERT INTO `product` VALUES (25, '小明的妙脆角 120克', 0.01, 999, NULL, 5, '/product-cake@1.png', 1, 1, 0, NULL, NULL, NULL, 52);
INSERT INTO `product` VALUES (26, '红衣青瓜 混搭160克', 0.01, 999, NULL, 2, '/product-dryfruit@8.png', 1, 1, 0, NULL, NULL, NULL, 56);
INSERT INTO `product` VALUES (27, '锈色瓜子 100克', 0.01, 998, NULL, 4, '/product-fry@4.png', 1, 1, 11, NULL, NULL, NULL, 57);
INSERT INTO `product` VALUES (28, '春泥花生 200克', 0.01, 999, NULL, 4, '/product-fry@5.png', 1, 1, 0, NULL, NULL, NULL, 58);
INSERT INTO `product` VALUES (29, '冰心鸡蛋 2个', 0.01, 999, NULL, 7, '/product-rice@5.png', 1, 1, 0, NULL, NULL, NULL, 59);
INSERT INTO `product` VALUES (30, '八宝莲子 200克', 0.01, 999, NULL, 7, '/product-rice@6.png', 1, 1, 9, NULL, NULL, NULL, 14);
INSERT INTO `product` VALUES (31, '深涧木耳 78克', 0.01, 999, NULL, 7, '/product-rice@7.png', 1, 1, 10, NULL, NULL, NULL, 60);
INSERT INTO `product` VALUES (32, '土豆 半斤', 0.01, 999, NULL, 3, '/product-vg@4.png', 1, 1, 98, NULL, NULL, NULL, 66);
INSERT INTO `product` VALUES (33, '青椒 半斤', 0.01, 999, NULL, 3, '/product-vg@5.png', 1, 1, 99, NULL, NULL, NULL, 67);
INSERT INTO `product` VALUES (6859225246, '濑尿虾寿司 100给', 10.00, 99, 1587210485, 7, '/5037bffcdf09bc7c/b5261a08189ea4be.png', 1, 0, 0, NULL, 1585937785, '描述11', 161);
INSERT INTO `product` VALUES (6866077592, 'test', 1.00, 1, 1587210480, 5, '/92e953fad71f84b6/7c463eeddd5606ee.png', 1, 0, 0, NULL, 1586607786, '', 174);
INSERT INTO `product` VALUES (6866078548, 'test4444', 1.00, 2, 1587210476, 5, '/92e953fad71f84b6/7c463eeddd5606ee.png', 1, 0, 0, NULL, 1586607893, '', 175);

-- ----------------------------
-- Table structure for product_image
-- ----------------------------
DROP TABLE IF EXISTS `product_image`;
CREATE TABLE `product_image`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `img_id` int(11) NOT NULL COMMENT '外键，关联图片表',
  `delete_time` int(11) NULL DEFAULT NULL COMMENT '状态，主要表示是否删除，也可以扩展其他状态',
  `order` int(11) NOT NULL DEFAULT 0 COMMENT '图片排序序号',
  `product_id` bigint(20) NOT NULL COMMENT '商品id，外键',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 57 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_image
-- ----------------------------
INSERT INTO `product_image` VALUES (4, 19, NULL, 1, 11);
INSERT INTO `product_image` VALUES (5, 20, NULL, 2, 11);
INSERT INTO `product_image` VALUES (6, 21, NULL, 3, 11);
INSERT INTO `product_image` VALUES (7, 22, NULL, 4, 11);
INSERT INTO `product_image` VALUES (8, 23, NULL, 5, 11);
INSERT INTO `product_image` VALUES (9, 24, NULL, 6, 11);
INSERT INTO `product_image` VALUES (10, 25, NULL, 7, 11);
INSERT INTO `product_image` VALUES (11, 26, NULL, 8, 11);
INSERT INTO `product_image` VALUES (12, 27, NULL, 9, 11);
INSERT INTO `product_image` VALUES (13, 28, NULL, 11, 11);
INSERT INTO `product_image` VALUES (14, 29, NULL, 10, 11);
INSERT INTO `product_image` VALUES (18, 62, NULL, 12, 11);
INSERT INTO `product_image` VALUES (19, 63, NULL, 13, 11);
INSERT INTO `product_image` VALUES (54, 162, 1587210485, 0, 6859225246);
INSERT INTO `product_image` VALUES (56, 199, NULL, 0, 16);

-- ----------------------------
-- Table structure for product_property
-- ----------------------------
DROP TABLE IF EXISTS `product_property`;
CREATE TABLE `product_property`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '详情属性名称',
  `detail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '详情属性',
  `product_id` bigint(20) NOT NULL COMMENT '商品id，外键',
  `delete_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 97 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of product_property
-- ----------------------------
INSERT INTO `product_property` VALUES (1, '品名', '杨梅', 11, NULL, NULL);
INSERT INTO `product_property` VALUES (2, '口味', '青梅味 雪梨味 黄桃味 菠萝味', 11, NULL, NULL);
INSERT INTO `product_property` VALUES (3, '产地', '火星', 11, NULL, NULL);
INSERT INTO `product_property` VALUES (4, '保质期', '180天', 11, NULL, NULL);
INSERT INTO `product_property` VALUES (46, 'j', 'k', 6859228052, NULL, 1585935139);
INSERT INTO `product_property` VALUES (47, 'k', 'l', 6859351570, NULL, 1585935216);
INSERT INTO `product_property` VALUES (48, 'f', 'd', 6859352877, NULL, 1585935304);
INSERT INTO `product_property` VALUES (49, '2', '33', 6859356001, NULL, 1585935618);
INSERT INTO `product_property` VALUES (51, 'hello', 'world', 6859357697, NULL, 1585935923);
INSERT INTO `product_property` VALUES (53, 'w', 'e', 6859359700, NULL, 1585936001);
INSERT INTO `product_property` VALUES (54, 'Q', 'w', 6859363915, NULL, 1585936408);
INSERT INTO `product_property` VALUES (55, 'dZ', 'dd', 6859364996, NULL, 1585936518);
INSERT INTO `product_property` VALUES (56, 'fg', '', 6859365792, NULL, 1585936592);
INSERT INTO `product_property` VALUES (57, 'jj', '', 6859367789, NULL, 1585936793);
INSERT INTO `product_property` VALUES (58, 'a', 'ggg', 6859368217, NULL, 1585936834);
INSERT INTO `product_property` VALUES (59, 'W', 'gg', 6859369625, NULL, 1585936973);
INSERT INTO `product_property` VALUES (60, 'q', 'a', 6859374796, NULL, 1585937509);
INSERT INTO `product_property` VALUES (61, '555', '....', 6859376698, NULL, 1585937689);
INSERT INTO `product_property` VALUES (62, '保质期', '3天', 6859225246, NULL, 1585937785);
INSERT INTO `product_property` VALUES (64, '保质期', '12个月', 12, NULL, 1586607214);
INSERT INTO `product_property` VALUES (66, '品名', '梨子', 2, NULL, 1586607454);
INSERT INTO `product_property` VALUES (67, '产地', '金星', 2, NULL, 1586607454);
INSERT INTO `product_property` VALUES (68, '净含量', '100g', 2, NULL, 1586607454);
INSERT INTO `product_property` VALUES (69, '保质期', '10天', 2, NULL, 1586607454);
INSERT INTO `product_property` VALUES (73, '保质期', '12个月', 6866077592, NULL, 1586607786);
INSERT INTO `product_property` VALUES (74, '1', '2', 6866078548, NULL, 1586607893);
INSERT INTO `product_property` VALUES (77, '保质期', '3天', 1, NULL, 1586669342);
INSERT INTO `product_property` VALUES (85, '保质期', '12个月', 7, NULL, 1586673207);
INSERT INTO `product_property` VALUES (86, '1', '2', 5, NULL, 1587233948);
INSERT INTO `product_property` VALUES (87, '1', '2', 4, NULL, 1587235718);
INSERT INTO `product_property` VALUES (90, '1', '2', 10, NULL, 1587236399);
INSERT INTO `product_property` VALUES (96, '保质期', '3天', 16, NULL, 1588153171);

-- ----------------------------
-- Table structure for system_config
-- ----------------------------
DROP TABLE IF EXISTS `system_config`;
CREATE TABLE `system_config`  (
  `type` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '分类',
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配置名',
  `value` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT '' COMMENT '配置值',
  INDEX `idx_system_config_type`(`type`) USING BTREE,
  INDEX `idx_system_config_name`(`name`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '系统-配置' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of system_config
-- ----------------------------
INSERT INTO `system_config` VALUES ('1', 'app_name', 'SimpleStore');
INSERT INTO `system_config` VALUES ('2', 'site_name', '日惠优品');
INSERT INTO `system_config` VALUES ('3', 'app_version', 'v4.1');
INSERT INTO `system_config` VALUES ('4', 'site_copy', '©版权所有 2019-2020 日惠优品云科技工作室');
INSERT INTO `system_config` VALUES ('5', 'site_icon', '/f24bcae49c383c6e/83e0d1f1505cca38.png');
INSERT INTO `system_config` VALUES ('7', 'miitbeian', '粤ICP备16006642号-2');
INSERT INTO `system_config` VALUES ('8', 'storage_type', 'local');
INSERT INTO `system_config` VALUES ('9', 'storage_local_exts', 'doc,gif,icon,jpg,mp3,mp4,p12,pem,png,rar');
INSERT INTO `system_config` VALUES ('10', 'storage_qiniu_bucket', 'https');
INSERT INTO `system_config` VALUES ('11', 'storage_qiniu_domain', '用你自己的吧');
INSERT INTO `system_config` VALUES ('12', 'storage_qiniu_access_key', '用你自己的吧');
INSERT INTO `system_config` VALUES ('13', 'storage_qiniu_secret_key', '用你自己的吧');
INSERT INTO `system_config` VALUES ('14', 'storage_oss_bucket', 'cuci-mytest');
INSERT INTO `system_config` VALUES ('15', 'storage_oss_endpoint', 'oss-cn-hangzhou.aliyuncs.com');
INSERT INTO `system_config` VALUES ('16', 'storage_oss_domain', '用你自己的吧');
INSERT INTO `system_config` VALUES ('17', 'storage_oss_keyid', '用你自己的吧');
INSERT INTO `system_config` VALUES ('18', 'storage_oss_secret', '用你自己的吧');
INSERT INTO `system_config` VALUES ('36', 'storage_oss_is_https', 'http');
INSERT INTO `system_config` VALUES ('43', 'storage_qiniu_region', '华东');
INSERT INTO `system_config` VALUES ('44', 'storage_qiniu_is_https', 'https');
INSERT INTO `system_config` VALUES ('45', 'wechat_mch_id', '1332187001');
INSERT INTO `system_config` VALUES ('46', 'wechat_mch_key', 'A82DC5BD1F3359081049C568D8502BC5');
INSERT INTO `system_config` VALUES ('47', 'wechat_mch_ssl_type', 'p12');
INSERT INTO `system_config` VALUES ('48', 'wechat_mch_ssl_p12', '65b8e4f56718182d/1bc857ee646aa15d.p12');
INSERT INTO `system_config` VALUES ('49', 'wechat_mch_ssl_key', 'cc2e3e1345123930/c407d033294f283d.pem');
INSERT INTO `system_config` VALUES ('50', 'wechat_mch_ssl_cer', '966eaf89299e9c95/7014872cc109b29a.pem');
INSERT INTO `system_config` VALUES ('51', 'wechat_token', 'mytoken');
INSERT INTO `system_config` VALUES ('52', 'wechat_appid', 'wx60a43dd8161666d4');
INSERT INTO `system_config` VALUES ('53', 'wechat_appsecret', '9978422e0e431643d4b42868d183d60b');
INSERT INTO `system_config` VALUES ('54', 'wechat_encodingaeskey', '');
INSERT INTO `system_config` VALUES ('55', 'wechat_push_url', '消息推送地址：http://127.0.0.1:8000/wechat/api.push');
INSERT INTO `system_config` VALUES ('56', 'wechat_type', 'thr');
INSERT INTO `system_config` VALUES ('57', 'wechat_thr_appid', 'wx60a43dd8161666d4');
INSERT INTO `system_config` VALUES ('58', 'wechat_thr_appkey', '6d1116ba978018ceb84d24d6dda4fed0');
INSERT INTO `system_config` VALUES ('60', 'wechat_thr_appurl', '消息推送地址：http://127.0.0.1:8000/wechat/api.push');
INSERT INTO `system_config` VALUES ('61', 'component_appid', 'wx28b58798480874f9');
INSERT INTO `system_config` VALUES ('62', 'component_appsecret', '87ddce1cc24e4cd691039f926febd942');
INSERT INTO `system_config` VALUES ('63', 'component_token', 'P8QHTIxpBEq88IrxatqhgpBm2OAQROkI');
INSERT INTO `system_config` VALUES ('64', 'component_encodingaeskey', 'L5uFIa0U6KLalPyXckyqoVIJYLhsfrg8k9YzybZIHsx');
INSERT INTO `system_config` VALUES ('65', 'system_message_state', '0');
INSERT INTO `system_config` VALUES ('66', 'sms_zt_username', '可以找CUCI申请');
INSERT INTO `system_config` VALUES ('67', 'sms_zt_password', '可以找CUCI申请');
INSERT INTO `system_config` VALUES ('68', 'sms_reg_template', '您的验证码为{code}，请在十分钟内完成操作！');
INSERT INTO `system_config` VALUES ('69', 'sms_secure', '可以找CUCI申请');
INSERT INTO `system_config` VALUES ('70', 'store_title', '测试商城');
INSERT INTO `system_config` VALUES ('71', 'store_order_wait_time', '0.50');
INSERT INTO `system_config` VALUES ('72', 'store_order_clear_time', '24.00');
INSERT INTO `system_config` VALUES ('73', 'store_order_confirm_time', '60.00');
INSERT INTO `system_config` VALUES ('74', 'site_logo', '/f24bcae49c383c6e/83e0d1f1505cca38.png');
INSERT INTO `system_config` VALUES ('75', 'site_logo_bg', '/73433d25f9419882/2de149051bf75f3c.png');
INSERT INTO `system_config` VALUES ('76', 'site_intro', '产品仅作为案例演示，已屏蔽支付系统');
INSERT INTO `system_config` VALUES ('77', 'contact_way_a_title', '客服咨询微信号：Levi');
INSERT INTO `system_config` VALUES ('78', 'contact_way_a_img', '/337fe2e699bdd30f/3f8d8affe8c41cad.png');
INSERT INTO `system_config` VALUES ('79', 'contact_way_b_title', '商务合作微信号：Levi');
INSERT INTO `system_config` VALUES ('80', 'contact_way_b_img', '/337fe2e699bdd30f/3f8d8affe8c41cad.png');

-- ----------------------------
-- Table structure for theme
-- ----------------------------
DROP TABLE IF EXISTS `theme`;
CREATE TABLE `theme`  (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '专题名称',
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '专题描述',
  `topic_img_id` int(11) NOT NULL COMMENT '主题图，外键',
  `status` tinyint(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT '销售状态。0，未上线；1，已上线',
  `sort` int(1) UNSIGNED NOT NULL DEFAULT 0 COMMENT '排序权重',
  `delete_time` int(11) NULL DEFAULT NULL,
  `head_img_id` int(11) NOT NULL COMMENT '专题列表页，头图',
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '主题信息表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of theme
-- ----------------------------
INSERT INTO `theme` VALUES (1, '专题栏位一', '美味水果世界', 16, 1, 0, NULL, 49, 1587953008);
INSERT INTO `theme` VALUES (2, '专题栏位二', '新品推荐', 17, 1, 2, NULL, 50, 1587898328);
INSERT INTO `theme` VALUES (3, '专题栏位三3', '做个干物女11', 18, 1, 3, NULL, 18, 1588155698);

-- ----------------------------
-- Table structure for theme_product
-- ----------------------------
DROP TABLE IF EXISTS `theme_product`;
CREATE TABLE `theme_product`  (
  `theme_id` bigint(20) NOT NULL COMMENT '主题外键',
  `product_id` bigint(20) NOT NULL COMMENT '商品外键',
  PRIMARY KEY (`theme_id`, `product_id`) USING BTREE
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '主题所包含的商品' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of theme_product
-- ----------------------------
INSERT INTO `theme_product` VALUES (1, 2);
INSERT INTO `theme_product` VALUES (1, 5);
INSERT INTO `theme_product` VALUES (1, 8);
INSERT INTO `theme_product` VALUES (1, 10);
INSERT INTO `theme_product` VALUES (1, 12);
INSERT INTO `theme_product` VALUES (2, 1);
INSERT INTO `theme_product` VALUES (2, 2);
INSERT INTO `theme_product` VALUES (2, 3);
INSERT INTO `theme_product` VALUES (2, 5);
INSERT INTO `theme_product` VALUES (2, 6);
INSERT INTO `theme_product` VALUES (2, 16);
INSERT INTO `theme_product` VALUES (2, 33);
INSERT INTO `theme_product` VALUES (3, 16);
INSERT INTO `theme_product` VALUES (3, 17);
INSERT INTO `theme_product` VALUES (3, 18);
INSERT INTO `theme_product` VALUES (3, 19);
INSERT INTO `theme_product` VALUES (3, 30);
INSERT INTO `theme_product` VALUES (3, 33);
INSERT INTO `theme_product` VALUES (16, 16);

-- ----------------------------
-- Table structure for third_app
-- ----------------------------
DROP TABLE IF EXISTS `third_app`;
CREATE TABLE `third_app`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '应用app_id',
  `app_secret` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '应用secret',
  `app_description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '应用程序描述',
  `scope` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '32' COMMENT '应用权限',
  `scope_description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '权限描述',
  `delete_time` int(11) NULL DEFAULT NULL,
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci COMMENT = '访问API的各应用账号密码表' ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of third_app
-- ----------------------------
INSERT INTO `third_app` VALUES (1, 'starcraft', 'e19d5cd5af0378da05f63f891c7467af', 'CMS', '32', 'Super', NULL, NULL);
INSERT INTO `third_app` VALUES (2, 'test', 'e19d5cd5af0378da05f63f891c7467af', 'abcd1234', '32', 'abcd1234', NULL, NULL);

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `openid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nickname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `extend` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `delete_time` int(11) NULL DEFAULT NULL,
  `create_time` int(11) NULL DEFAULT NULL COMMENT '注册时间',
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `openid`(`openid`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 59 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES (58, 'ojzsA0ZYfp4VrxlupXfpLEVKGdo4', '张三', NULL, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for user_address
-- ----------------------------
DROP TABLE IF EXISTS `user_address`;
CREATE TABLE `user_address`  (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '收获人姓名',
  `mobile` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL COMMENT '手机号',
  `province` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '省',
  `city` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '市',
  `country` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '区',
  `detail` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL COMMENT '详细地址',
  `delete_time` int(11) NULL DEFAULT NULL,
  `user_id` int(11) NOT NULL COMMENT '外键',
  `update_time` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `user_id`(`user_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 36 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user_address
-- ----------------------------
INSERT INTO `user_address` VALUES (35, 'levi', '15220501265', '广东省', '深圳市', '宝安区', '新屋园2巷3号', NULL, 58, 1586622551);

SET FOREIGN_KEY_CHECKS = 1;
