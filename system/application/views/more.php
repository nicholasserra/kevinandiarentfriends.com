<?php                                                
 

if(isset($_COOKIE['author']))
{
    $author = $_COOKIE['author'];
}
else
{
    $author = '';     
}

if(isset($_COOKIE['email']))
{
    $email = $_COOKIE['email'];
}
else
{
    $email = '';     
}
?>
        <div class="line"></div>
        <?php for($i = 0; $i < count($items); $i++): ?>
        <div class="item">
            <p class="tweet">&#8220; <?php echo $items[$i]['message']; ?> &#8221; </p>
            <p class="date">posted on <?php echo date('F jS, Y', $items[$i]['timestamp']); ?> &lt;/3</p>
            
            <?php if(count($items[$i]['comments']) > 0): ?>
            <a class="comments" href="#">comments (<p class="commentcount"><?php echo count($items[$i]['comments']); ?></p>)</a> | <a class="addcomment" href="#">add comment?</a>
            <?php else: ?>
            <a class="comments" href="#">no comments</a> | <a class="addcomment" href="#">add comment?</a>
            <?php endif; ?>
            
            <form class="commentform" action="" method="POST" style="display:none;">
                <label>your name:</label>
                <input type="text" name="author" class="inputauthor inputbox" value="<?php echo $author; ?>" /><p class="error" style="display:none">!!!</p>

                <label>email (for notifications!):</label>
                <input type="text" name="email" class="inputemail inputbox" value="<?php echo $email; ?>" /><p class="error" style="display:none">!!!</p>

                <label>comment:</label>
                <textarea name="message" class="inputmessage inputbox"></textarea><p class="error" style="display:none">!!!</p>
                
                <input type="hidden" name="tweetid" class="inputtweetid" value="<?php echo $items[$i]['id']; ?>" />
                
                <a href="#" class="submitcomment">submit comment</a>
            </form>
            
            <div class="commentitem" style="display:none;">
                <ul>
                <?php $comments = $items[$i]['comments']; ?>
                <?php for($count = 0; $count < count($comments); $count++): ?>
                    <li>
                        <em><?php echo $comments[$count]['author']; ?></em> on <em><?php echo date('m.d.Y', $comments[$count]['timestamp']); ?></em> said:<br />
                        <?php echo $comments[$count]['message']; ?>
                    </li>
                <?php endfor; ?>
                </ul>
            </div>
            
            <div style="clear:both;"></div>
        </div>
        <?php if($i != count($items)-1): ?>
        <div class="line"></div>
        <?php endif; ?>
        <?php endfor; ?>