<?php

use Illuminate\Support\Facades\Route;

// R E D I R E C T I N G

// H O M E   P A G E
Route::get('/', function () {
    $chartype = request('chartype', 'all');
    $sort = request('orderby', 'create_at');
    
    // sorting
    $orderby = 'created_at';
    $direction = 'desc';
    if ($sort == 'bc') {
        $orderby = 'avg_rating';
        $direction = 'desc';
    } elseif ($sort == 'cd') {
        $orderby = 'avg_rating';
        $direction = 'asc';
    } elseif ($sort == 'de') {
        $ordery = 'total_reviews';
        $direction = 'desc';
    } elseif ($sort == 'ef') {
        $orderby = 'total_reviews';
        $direciton = 'asc';
    }

    $tankposts = select_posts('chartype', 'Tank', $orderby, $direction);
    $damageposts = select_posts('chartype', 'Damage', $orderby, $direction);
    $supportposts = select_posts('chartype', 'Support', $orderby, $direction);

    return view('layouts/home')
        ->with('tankposts', $tankposts)
        ->with('damageposts', $damageposts)
        ->with('supportposts', $supportposts);
});

// A D V I C E   P A G E
Route::get('advice', function () {
    $chartype = request('chartype', 'all');
    $sort = request('orderby', 'create_at');
    
    // sorting
    $orderby = 'created_at';
    $direction = 'desc';
    if ($sort == 'bc') {
        $orderby = 'avg_rating';
        $direction = 'desc';
    } elseif ($sort == 'cd') {
        $orderby = 'avg_rating';
        $direction = 'asc';
    } elseif ($sort == 'de') {
        $orderby = 'total_reviews';
        $direction = 'desc';
    } elseif ($sort == 'ef') {
        $orderby = 'total_reviews';
        $direction = 'asc';
    }

    $adviceposts = select_char_post('Advice', 'chartype', $chartype, $orderby, $direction);
    $total = count($adviceposts);

    return view('layouts/advice')
        ->with('adviceposts', $adviceposts)
        ->with('total', $total);
});

// A S S I S T A N C E   P A G E
Route::get('assistance', function () {
    $chartype = request('chartype', 'all');
    $sort = request('orderby', 'created_at'); 

    // sorting
    $orderby = 'created_at';
    $direction = 'desc';
    if ($sort == 'bc') {
        $orderby = 'total_reviews';
        $direction = 'desc';
    } elseif ($sort == 'cd') {
        $orderby = 'total_reviews';
        $direction = 'asc';
    }
    
    $assistposts = select_char_post('Assistance', 'chartype', $chartype, $orderby, $direction);
    $total = count($assistposts);

    
    return view('layouts/assistance')
        ->with('assistposts', $assistposts)
        ->with('total', $total);
});

// G A M E R S   P A G E
Route::get('gamers', function () {
    $sort = request('orderby', 'p.created_at'); 

    $orderby = 'p.created_at';
    $direction = 'desc';
    if ($sort == 'ab') {
        $orderby = 'user_avg_rating';
        $direction = 'desc';
    } elseif ($sort == 'bc') {
        $orderby = 'user_avg_rating';
        $direction = 'asc';
    } elseif ($sort == 'cd') {
        $orderby = 'total_posts';
        $direction = 'desc';
    }
    $gamers = select_gamers($orderby, $direction);
    $total = count($gamers);

    return view('layouts/gamers')
    ->with('gamers', $gamers)
    ->with('total', $total);
});


// G A M E R   D E T A I L S
Route::get('gamertag/{userID}', function ($userID) {
    $gamer = select_gamer_details($userID);
    $sort = request('orderby', 'create_at');

    // sorting
    $orderby = 'created_at';
    $direction = 'desc';
    if ($sort == 'bc') {
        $orderby = 'avg_rating';
        $direction = 'desc';
    } elseif ($sort == 'cd') {
        $orderby = 'avg_rating';
        $direction = 'asc';
    } elseif ($sort == 'de') {
        $orderby = 'total_reviews';
        $direction = 'desc';
    } elseif ($sort == 'ef') {
        $orderby = 'total_reviews';
        $direction = 'asc';
    }

    // filter and show posts
    $posts = select_posts('u.userID', $userID, $orderby, $direction);

    return view('layouts/gamertag')
    ->with('gamer', $gamer)
    ->with('posts', $posts);
});

// C R E A T E   P O S T   P A G E
Route::get('create_post', function () {
    $characters = all_characters();
    if (!Session::has('username')) {
        return redirect('create_user')->with('Please create a user first.');
    }
    return view('posts/create_post')->with('characters', $characters)->with('username', Session::get('username'))->with('no_of_hrs', Session::get('no_of_hrs'));
});

// P O S T   D E T A I L S   P A G E
Route::get('post_detail/{postID}', function($postID){
    $post = get_post($postID);
    $postuserID = $post->userID;
    $reviews = get_reviews($postID);
    $editReview = request()->query('edit');

    // check the user
    if (!Session::has('username')) {
        $userID = null;
    } else {
        $userID = get_userID(Session::get('username'));
    }

    // chekc if there are any reviews
    if ($reviews) {
        $avg_rating = get_avg_rating($postID);
        $total_reviews = get_total_reviews($postID);
    } else {
        $avg_rating = 0;
        $total_reviews = 0;
    }

    // check if user has commented before, or has been banned, or if comments have been disabled
    $existingComment = already_commented($userID, $postID);
    $userBanned = check_banned($userID);
    $commentsDisabled = check_disabled($postuserID);
    if ($userBanned) {
        return redirect()->back()->with('error', 'You are banned from commenting.');
    }

    if ($commentsDisabled) {
        return redirect()->back()->with('error', 'Comments are disabled for this user.');
    }

    if (request()->isMethod('post')) {
        if (!Session::has('username')) {
            return redirect()->back()->with('error', 'You must create a user before adding a comment.');
        }
        if ($existingComment) {
            return redirect()->back()->with('error', 'You have already posted a review on this post.');
        }

        return redirect()->back()->with('success', 'Your comment has been added.');
    }  

    // Pass the post and comments to the Blade template
    return view('posts.post_detail')
    ->with('post', $post)
    ->with('reviews', $reviews)
    ->with('avg_rating', $avg_rating)
    ->with('total_reviews', $total_reviews)
    ->with('existingComment', $existingComment)
    ->with('editReview', $editReview)
    ->with('userBanned', $userBanned)
    ->with('commentsDisabled', $commentsDisabled);
});

// C R E A T E   U S E R   P A G E
Route::get('create_user', function () {
    Session::put('redirect_url', url()->previous());
    return view('posts/create_user');
});

// C L E A R   S E S S I O N
Route::get('/clear-session', function () {
    // Clear the entire session
    Session::flush();
    return redirect()->back()->with('success', 'Session cleared!');
});


// A C T I O N S

// C R E A T E   U S E R
Route::post('create_user_action', function () {
    $username = request('username');
    $no_of_hrs = request('no_of_hrs');
    $errors = [];

    // input validation
    $check = check_name($username);
    if ($check !== true){
        $errors[] = $check;
    }
    if (!is_numeric($no_of_hrs)) {
        $errors[] = 'Numbers of hours must be numbers';
    }

    // cleaning the username
    $check = numbers_in($username);
    if ($check !== true){
        $modified = change_username($username);
        $username = $modified;
    } else {
        $modified = null;
    }

    // check if username exists
    $sql = "select username from user where username = ?";
    $existingUser = DB::select($sql, [$username]);
    if ($existingUser) {
        $errors = 'This username is already taken.';
    }

    // check if any errors
    if (!empty($errors)) {
        return redirect()->back()->withErrors($errors);
    }

    Session::put('username', $username);
    create_user($username, $no_of_hrs);

    $redirectUrl = Session::get('redirect_url', '/');
    Session::forget('redirect_url'); // Remove the redirect URL from the session
    if ($modified) {
        return redirect($redirectUrl)->with('success', 'User created successfully! Your name has been changed to: '.$modified);
    } else {
        return redirect($redirectUrl)->with('success', 'User created successfully!');
    }
});

// C R E A T E   P O S T
Route::post('create_post_action', function(){
    $title = request('title');
    $check = check_name($title);
    if ($check !== true){
        return redirect()->back()->with('error', $check);
    }
    $platform = request('platform');
    $posttype = request('posttype');
    $content = request('content');
    $created_at = now()->format('d-m-Y');
    $characterID = request('characterID');
    $username = Session::get('username');
    $userID = get_userID($username);
    if (!$userID) {
        return redirect('create_user')->with('error', 'User ID not found. Please create a user.');
    }
    $postID = create_post($title, $platform, $posttype, $content, $created_at, $characterID, $userID);
        // If there post was successful, a postID will be generated and you will be redirected to its page
    if ($postID){
        return redirect(url("post_detail/$postID"));

    } else {
        return redirect('create_post')->with('error', 'Error while creating post.');
    }
});

// C R E A T E   R E V I E W
Route::post('create_review_action/{postID}', function($postID){
    $rating = request('rating');
    $content = request('content');
    $created_at = now()->format('d-m-Y');
    $username = Session::get('username');
    $userID = get_userID($username);
    $id = $postID;
    $postdetails = get_post($id);
    $postuserID = $postdetails->userID;
    if (!$userID) {
        return redirect('create_user')->with('error', 'User ID not found. Please create a user.');
    }

    // check if the last 5 reviews were for the same user
    $commentcounting = count_comments($userID, $postuserID);
    if ($commentcounting >= 5) {
        ban_user($userID);
        return redirect()->back()->with('error', 'You have been banned from commenting due to repeated comments.');
    }

    // check if 75% of a user's reviews are for the same user after 9 posts
    $totalreviews = get_total('review', 'userID', $userID);
    if ($totalreviews > 9) {
        $percentage = ($commentcounting/$totalreviews) * 100;
        if ($percentage >= 75) {
            ban_user($userID);
            return redirect()->back()->with('error', 'You have been banned from commenting due to repeated comments on the same user.');
        }
    }

    // check if a user has received 20 or more high reviews in the last minute
    $now = now();
    $startTime = $now->subMinute();
    $highratings = check_highreviews($postuserID, $startTime, $now);
    if ($highratings >= 20) {
        disable_comments($postuserID);
        return redirect()->back()->with('error', 'Comments have been disabled for this user and will be investigated soon.');
    }

    $reviewID = create_review($rating, $content, $created_at, $userID, $id);
    if ($reviewID){
        return redirect(url("post_detail/$postID"));
    } else {
        return redirect()->back()->with('error', 'Error while submitting the review.');
    }
});

// E D I T   R E V I E W
Route::post('edit_review_action/{reviewID}', function($reviewID){
    $username = Session::get('username');
    $userID = get_userID($username);
    $rating = request('rating');
    $content = request('content');
    $updated_at = now()->format('d-m-Y');
    $postID = get_particular_review($reviewID);
    $postID = $postID->postID;

    if (!$userID) {
        return redirect('create_user');
    }
    $postdetails = get_post($postID);
    $postuserID = $postdetails->userID;

    // check if the last 5 reviews were for the same user
    $commentcounting = count_comments($userID, $postuserID);
    if ($commentcounting >= 5) {
        ban_user($userID);
        return redirect()->back()->with('error', 'You have been banned from commenting due to repeated comments.');
    }

    // check if 75% of a user's reviews are for the same user after 9 posts
    $totalreviews = get_total('review', 'userID', $userID);
    if ($totalreviews > 9) {
        $percentage = ($commentcounting/$totalreviews) * 100;
        if ($percentage >= 75) {
            ban_user($userID);
            return redirect()->back()->with('error', 'You have been banned from commenting due to repeated comments on the same user.');
        }
    }

    // check if a user has received 20 or more high reviews in the last minute
    $now = now();
    $startTime = $now->subMinute();
    $highratings = check_highreviews($postuserID, $startTime, $now);
    if ($highratings >= 20) {
        disable_comments($postuserID);
        return redirect()->back()->with('error', 'Comments have been disabled for this user and will be investigated soon.');
    }

    $updateReview = update_review($reviewID, $rating, $content, $updated_at);
    if ($updateReview){
        return redirect(url("post_detail/$postID"))->with('success', 'Review updated successfully.');
    } else {
        return redirect()->back()->with('error', 'Error while updating the review.');
    }
});

// D E L E T E   P O S T
Route::post('delete_post_action/{postID}', function($postID) {
    if (!$postID) {
        return redirect(url('/'))->with('error', 'Post does not exist.');
    } else {
        delete_post($postID);
        return redirect(url('/'))->with('success', 'Post deleted.');
    }
});






// F U N C T I O N S

// C R E A T I N G

// Function for creating a post
function create_post($title, $platform, $posttype, $content, $created_at, $characterID, $userID){
    $sql = "insert into post (postID, title, platform, posttype, content, created_at, updated_at, characterID, userID) values (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    DB::insert($sql, array(null, $title, $platform, $posttype, $content, $created_at, null, $characterID, $userID));
    $postID = DB::getPdo()->lastInsertId();
    return ($postID);
};

// Function for creating a user
function create_user($username, $no_of_hrs){
    $sql = "insert into user (userID, username, no_of_hrs, comment_banned, disable_comments) values (?, ?, ?, ?, ?)";
    DB::insert($sql, array(null, $username, $no_of_hrs, false, false));
    $userID = DB::getPdo()->lastInsertId();
    return ($userID);
};

// Function for creating a review
function create_review($rating, $content, $created_at, $userID, $postID){
    $sql = "insert into review (rating, content, created_at, userID, postID) values (?, ?, ?, ?, ?)";
    DB::insert($sql, [$rating, $content, $created_at, $userID, $postID]);
    $commentID = DB::getPdo()->lastInsertId();
    return ($commentID);
};

// U P D A T I N G

// Function for updating a review
function update_review($reviewID, $rating, $content, $updated_at){
    $sql = "update review set rating = ?, content = ?, updated_at = ? where reviewID = ?";
    return DB::update($sql, [$rating, $content, $updated_at, $reviewID]);
}

// D E L E T I N G

// Function for deleting a post
function delete_post($postID) {
    $sql = "delete from review where postID=?";
    DB::delete($sql, [$postID]);

    $sql = "delete from post where postID=?";
    DB::delete($sql, [$postID]);
}


// R E T R I E V I N G

// Function for retrieving the userID
function get_userID($username){
    $sql = "select userID from user where username=?";
    $result = DB::select($sql, array($username));
    if (count($result) != 1) {
        return redirect()->back()->with('error', 'No such user exists');
    }
    $userID = $result[0]->userID;
    return $userID;
};

// Function for retrieving a post
function get_post($postID){
    $sql = "
    select p.*, u.*, OW.*
    from post AS p
    JOIN user AS u ON u.userID = p.userID
    JOIN OWcharacter AS OW ON OW.characterID = p.characterID
    where p.postID = ?;";
    $posts = DB::select($sql, array($postID));
    if (count($posts) != 1){
        return "Something has gone wrong, invalid query or result";
    }
    $post = $posts[0];
    return $post;
};


// Function for retrieving a review
function get_particular_review($reviewID){
    $sql = "SELECT * FROM review WHERE reviewID = ?";
    $reviews = DB::select($sql, [$reviewID]);
    if (count($reviews) != 1) {
        return null;
    }
    return $reviews[0];
}

// Function for retrieving the reviews of a post
function get_reviews($postID) {
    $sql = "SELECT r.*, u.* FROM review as r, user as u WHERE r.userID=u.userID AND postID = ?";
    $result = DB::select($sql, [$postID]);
    return $result;
}

function get_userdetails($userID) {
    $sql = "select * from user where userID = ?";
    $result = DB::select($sql, [$userID]);
    return $result;
}

// Function to get the average rating of a post
function get_avg_rating($postID){
    $sql = "select ROUND(AVG(r.rating), 1) as avg_rating from post as p, review as r where r.postID=?";
    $avg = DB::select($sql, array($postID));
    $avg_rating = $avg[0]->avg_rating;
    return $avg_rating;
}

// Function to get the total number of reviews on a post
function get_total_reviews($postID){
    $sql = "select COUNT(reviewID) as total_reviews from review where postID=?";
    $total = DB::select($sql, array($postID));
    $total_reviews = $total[0]->total_reviews;
    return $total_reviews;
}

// Function to retrieve all characters from the OWcharacter database
function all_characters(){
    $sql = "select * from OWcharacter";
    $characters = DB::select($sql);
    return $characters;
}

// C H E C K I N G

// Function to check if a user has already commented
function already_commented($userID, $postID) {
    $sql = "select postID from review where userID=? AND postID=?";
    $result = DB::select($sql, array($userID, $postID));
    if (count($result) > 0){
        return true;
    }
    return false;
    
}

// Function to check if there are any errors with the title or name
function check_name($name) {
    if (strlen($name) <= 2) {
        return 'Name must be more than 2 characters.';
    }
    if (preg_match('/[-_+""]/', $name)) {
        return 'Name cannot contain the symbols: -, _, +, or ".';
    }
    
    return true;
}

// Function to change the username if there are numbers involved
function numbers_in($name){
    for ($i = 0; $i < strlen($name); $i++){
        $char = $name[$i];
        if (is_numeric($char)){
            return false;
        }
    }
    return true;
};

// Function to change the username if there are numbers involved
function change_username($name) {
    $username = ""; // create an empty string, which will be the blank canvas to build the new username
    for ($i = 0; $i < strlen($name); $i++){
        $char = $name[$i];
        if (!is_numeric($char)){
            $username .= $char;
        }
    }
    return $username;
};

// S E L E C T I N G

// Function that selects certain types of posts and can sort them
function select_posts($filter, $type, $orderby = 'created_at', $direction = 'desc'){
    $sql = "select p.*, u.*, c.*, avg(r.rating) as avg_rating, count(r.reviewID) as total_reviews 
    from post as p
    JOIN user AS u ON p.userID = u.userID
    JOIN OWcharacter AS c ON p.characterID = c.characterID
    LEFT JOIN review AS r ON p.postID = r.postID
    WHERE $filter=?
    GROUP BY p.postID
    ORDER BY $orderby $direction";
    $result = DB::select($sql, [$type]);
    return $result;
}

// Function that sorts posts and can filter out character types
function select_char_post($posttype, $filter, $type, $orderby = 'created_at', $direction = 'desc') {
    $sql = "
        SELECT p.*, c.*, u.*, avg(r.rating) as avg_rating, count(r.reviewID) as total_reviews 
        FROM post AS p 
        LEFT JOIN review AS r ON p.postID = r.postID 
        JOIN OWcharacter AS c ON p.characterID = c.characterID
        JOIN user AS u ON p.userID = u.userID
        WHERE p.posttype = ?";

    if ($type !== 'all') {
        $sql .= " AND c.chartype = ?";  // Add chartype filter if it's not 'all'
    }
    
    $sql .= " 
        GROUP BY p.postID 
        ORDER BY $orderby $direction";

    // If filtering by chartype, bind both posttype and chartype; otherwise, bind only posttype
    if ($type !== 'all') {
        $result = DB::select($sql, [$posttype, $type]);
    } else {
        $result = DB::select($sql, [$posttype]);  // No chartype filtering
    }

    return $result;
}

// Function to select users who have created 'Advice' type posts
function select_gamers($orderby = 'p.created_at', $direction = 'desc') {
    $sql = "
        SELECT u.*, COUNT(p.postID) as total_posts, AVG(all_rating.avg_rating) as user_avg_rating
        FROM user AS u
        JOIN post AS p ON u.userID = p.userID
        LEFT JOIN (
            SELECT p.*, AVG(r.rating) as avg_rating
            FROM post AS p
            LEFT JOIN review AS r ON p.postID = r.postID
            GROUP BY p.postID
        ) as all_rating ON p.postID = all_rating.postID
        WHERE p.posttype = 'Advice'
        GROUP BY u.userID, u.username
        ORDER BY $orderby $direction";

    $result = DB::select($sql);
    return $result;
}

// Function to select a particular userID and all their details
function select_gamer_details($userID, $orderby = 'p.created_at', $direction = 'desc') {
    $sql = "
        SELECT u.*, COUNT(p.postID) as total_posts, AVG(all_rating.avg_rating) as user_avg_rating
        FROM user AS u
        JOIN post AS p ON u.userID = p.userID
        LEFT JOIN (
            SELECT p.*, AVG(r.rating) as avg_rating
            FROM post AS p
            LEFT JOIN review AS r ON p.postID = r.postID
            GROUP BY p.postID
        ) as all_rating ON p.postID = all_rating.postID
        WHERE p.posttype = 'Advice'
        AND u.userID = ?
        GROUP BY u.userID, u.username
        ORDER BY $orderby $direction";

    $result = DB::select($sql, [$userID]);
    return $result[0];
}

// Function to get the total from anything
function get_total($table, $filter, $type){
    $sql = "select count(*) as total from $table where $filter=?";
    $result = DB::select($sql, [$type]);
    if (count($result) > 0) {
        return $result[0]->total;
    } else {
        return false;
    }
}



// F A K E   R E V I E W   C H E C K S

// Function to ban users from commenting
function ban_user($userID){
    $sql = "update user set comment_banned = true where userID = ?";
    DB::update($sql, [$userID]);

    $sql = "delete from review where userID = ?";
    DB::delete($sql, [$userID]);
}

// Function to activate diable comments
function disable_comments($userID){
    $sql = "update user set disable_comments = true where userID = ?";
    DB::update($sql, [$userID]);
}

// Function to check if a user is banned from commenting
function check_banned($userID) {
    $sql = "select comment_banned from user where userID = ?";
    $result = DB::select($sql, [$userID]);
    if (count($result) > 0) {
        return $result[0]->comment_banned;
    } else {
        return false;
    }
}

// Function to check if a user has disabled_comments enabled
function check_disabled($userID) {
    $sql = "select disable_comments from user where userID = ?";
    $result = DB::select($sql, [$userID]);
    if (count($result) > 0) {
        return $result[0]->disable_comments;
    } else {
        return false;
    }
}


// Function to check if the last 5 reviews were under a particular user's post
function count_comments($userID, $targetedUserID) {
    $sql = "
    select COUNT(*) as target_user_reviews
    from review
    where userID = ?
    AND postID IN (
        select postID
        from post
        where userID = ?
    )
    ORDER BY created_at desc
    LIMIT 5;";
    $result = DB::select($sql, [$userID, $targetedUserID]);
    if (!empty($result) && isset($result[0]->targeted_user_reviews)) {
        $total = $result[0]->targeted_user_reviews; 
        return $total;
    }

    return 0;
}

// Function to check if in the last minute there were 20 or more highest rated reviews for a particular user
function check_highreviews($userID, $startTime, $now) {
    $sql = "
    select COUNT(*) AS high_rating_reviews
    from review
    where rating >= 4
    AND postID IN (
        select postID
        from post
        where userID = ?
    )
    AND created_at between ? AND ?";
    $result = DB::select($sql, [$userID, $startTime, $now]);
    $total = $result[0]->high_rating_reviews;
    return $total;
}

