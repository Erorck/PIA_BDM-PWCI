-- users.classes.php
USERS

$idUser = USER_ID INT
$nickname = USER_ALIAS VARCHAR(100)
$email = EMAIL VARCHAR(100)
$pwd = CREDENTIAL VARCHAR(75)
$name = FULL_NAME VARCHAR(200)
$phoneNumber = PHONE VARCHAR(15)
$pPicture = PROFILE_PICTURE LONGBLOB
$bPicture = BANNER_PICTURE LONGBLOB
$user_type = USER_TYPE CHAR(2)
$user_status = USER_STATUS CHAR(1)
$created_by = CREATED_BY INT
$updated_by = UPDATED_BY INT


-- categories.classes.php
CATEGORIES

$category_name = CATEGORY_NAME VARCHAR(40)
$order = ORDER TINYINT
$color = COLOR CHAR(7)
$created_by = CREATED_BY INT
$updated_by = UPDATED_BY INT
$section_status = SECTION_STATUS CHAR(1)


-- comments.classes.php
COMMENTS

$comment_id = COMMENT_ID INT
$comment_text = COMMENT_TEXT VARCHAR(1000)
$creation_date = CREATION_DATE DATETIME
$created_by = CREATED_BY INT
$comment_status = COMMENT_STATUS CHAR(2)


-- news.classes.php
NEWS_REPORTS

$report_id = REPORT_ID INT 
$sign = SIGN VARCHAR(100)
$street = LOCATION_STREET VARCHAR(100)
$neighbourhood = LOCATION_NEIGHB VARCHAR(70)
$city = LOCATION_CITY VARCHAR(80)
$country = LOCATION_COUNTRY VARCHAR(50)
$event_date = EVENT_DATE DATETIME
$publication_date = PUBLICATION_DATE DATETIME
$header = REPORT_HEADER VARCHAR(100)
$description = REPORT_DESCRIPTION VARCHAR(200)
$content = REPORT_CONTENT VARCHAR(500)
$likes = LIKES INT
$creation_date = CREATION_DATE DATETIME
$created_by = CREATED_BY INT
$updated_by = UPDATED_BY INT
$report_status = STATUS_NEWSCHAR(2)


-- comments_news.classes.php
COMMENTS_NEWS

$comment_id = COMMENT_ID INT
$report_id = REPORT_ID INT
$parent_id = PARENT_ID INT
$creation_date = CREATION_DATE DATETIME
$created_by = CREATED_BY INT
$active = ACTIVE BOOLEAN


-- news_categories.classes.php
NEWS_CATEGORIES

$report_id = REPORT_ID INT
$category_id = CATEGORY INT


-- news_pics.classes.php
IMAGES

$image_id = ID_IMAGE INT
$report_id = REPORT_ID INT
$content = CONTENT LONGBLOB
$route = ROUTE VARCHAR(1000)


-- news_videos.classes.php
VIDEOS

$video_id = ID_VIDEO INT
report_id = REPORT_ID INT
$content = CONTENT LONGBLOB
$route = ROUTE VARCHAR(1000)


-- news_keywords.classes.php
NEWS_TAGS

$tag = TAG VARCHAR(50)
$report_id = REPORT_ID INT


-- news_likes.classes.php
REACTIONS

$news_likes_id = NEWS_LIKES_ID INT
$liked LIKED BOOLEAN
$report_id = REPORT_ID INT
$user = USER INT
$creation_date = CREATION_DATE DATETIME
$created_by = CREATED_BY INT


