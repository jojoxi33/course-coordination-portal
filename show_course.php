<?php 
$page_title = "Course: " . htmlspecialchars($_GET['course']); 
include 'header.php';
?>

<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<link rel="stylesheet" href="assets/css/resource-styles.css">

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
$(function() {
    $("#tabs").tabs();
    
    // Search functionality - fixed to target resource cards
    $("#resource-search").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".resource-card").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    // Filter by type - fixed to target resource cards and sync with tabs
    $(".resource-filter").change(function() {
        var filter = $(this).val();
        
        // First handle the card visibility
        if (filter === "all") {
            $(".resource-card").show();
            // Switch to the All Resources tab
            $("#tabs").tabs("option", "active", 0);
        } else {
            $(".resource-card").hide();
            $(".resource-card[data-type='" + filter + "']").show();
            
            // Find the tab index for this filter and activate it
            var tabIndex = 0;
            $("#tabs ul li a").each(function(index) {
                if ($(this).attr('href') === '#tabs-' + filter.replace(' ', '-')) {
                    tabIndex = index;
                    return false; // break the loop
                }
            });
            $("#tabs").tabs("option", "active", tabIndex);
        }
    });
    
    // Sync tab changes with filter dropdown
    $("#tabs").on("tabsactivate", function(event, ui) {
        var tabId = ui.newPanel.attr('id');
        if (tabId === 'tabs-all') {
            $(".resource-filter").val('all');
            $(".resource-card").show();
        } else {
            var type = tabId.replace('tabs-', '').replace('-', ' ');
            $(".resource-filter").val(type);
            $(".resource-card").hide();
            $(".resource-card[data-type='" + type + "']").show();
        }
    });
});
</script>

<div class="resource-container">
    <div class="resource-header">
        <h1><?php echo htmlspecialchars($_GET['course']); ?> Resources</h1>
        
        <div class="resource-controls">
            <div class="search-box">
                <input type="text" id="resource-search" placeholder="Search resources...">
                <i class="bi bi-search"></i>
            </div>
            
            <div class="filter-box">
                <select class="resource-filter">
                    <option value="all">All Resource Types</option>
                    <option value="Research">Research</option>
                    <option value="Short Exam">Short Exam</option>
                    <option value="Powerpoint">Powerpoint</option>
                    <option value="Working Paper">Working Paper</option>
                    <option value="Video">Video</option>
                    <option value="Book">Book</option>
                    <option value="Article">Article</option>
                    <option value="Lecture">Lecture</option>
                </select>
            </div>
        </div>
    </div>

    <div id="tabs">
        <ul>
            <li><a href="#tabs-all">All Resources</a></li>
            <li><a href="#tabs-Research">Research</a></li>
            <li><a href="#tabs-Short-Exam">Short Exam</a></li>
            <li><a href="#tabs-Powerpoint">Powerpoint</a></li>
            <li><a href="#tabs-Working-Paper">Working Paper</a></li>
            <li><a href="#tabs-Video">Video</a></li>
            <li><a href="#tabs-Book">Book</a></li>
            <li><a href="#tabs-Article">Article</a></li>
            <li><a href="#tabs-Lecture">Lecture</a></li>
        </ul>
        
        <!-- All Resources Tab -->
        <div id="tabs-all">
            <div class="resource-grid">
                <?php
                // Combine all resource types
                $all_resources = array();
                $resource_types = ['Research', 'Short Exam', 'Powerpoint', 'Working Paper', 'Video', 'Book', 'Article', 'Lecture'];
                
                foreach ($resource_types as $type) {
                    $query = "SELECT * FROM resource WHERE course = '" . mysqli_real_escape_string($con, $_GET['course']) . "' AND type = '" . mysqli_real_escape_string($con, $type) . "'";
                    $result = mysqli_query($con, $query);
                    
                    while ($row = mysqli_fetch_assoc($result)) {
                        $row['resource_type'] = $type;
                        $all_resources[] = $row;
                    }
                }
                
                // Sort by date (newest first)
                usort($all_resources, function($a, $b) {
                    return strtotime($b['date']) - strtotime($a['date']);
                });
                
                foreach ($all_resources as $resource) {
                    $icon = getResourceIcon($resource['resource_type']);
                    $color = getResourceColor($resource['resource_type']);
                ?>
                <div class="resource-card" data-type="<?php echo $resource['resource_type']; ?>">
                    <div class="resource-icon" style="background-color: <?php echo $color; ?>">
                        <i class="bi <?php echo $icon; ?>"></i>
                    </div>
                    <div class="resource-content">
                        <h3><?php echo htmlspecialchars($resource['title']); ?></h3>
                        <p class="resource-meta">
                            <span class="resource-type" style="color: <?php echo $color; ?>">
                                <?php echo $resource['resource_type']; ?>
                            </span>
                            • <?php echo date('M d, Y', strtotime($resource['date'])); ?>
                        </p>
                        <p class="resource-desc"><?php echo htmlspecialchars($resource['description']); ?></p>
                        <div class="resource-actions">
                            <a href="show_resource_comments_rates.php?id=<?php echo $resource['id']; ?>" class="btn-comments">
                                <i class="bi bi-chat-left-text"></i> Comments
                            </a>
                            <?php if ($_SESSION['user_type'] == "student" || $_SESSION['user_type'] == "member") { ?>
                                <a href="assets/resources/<?php echo $resource['file']; ?>" target="_blank" class="btn-download">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            <?php } else { ?>
                                <span class="download-restricted">Download for students</span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        
        <!-- Individual Resource Type Tabs -->
        <?php 
        // Initialize variables for resource queries
        $resources_research_result = mysqli_query($con, "SELECT * FROM resource WHERE course = '" . mysqli_real_escape_string($con, $_GET['course']) . "' AND type = 'Research'");
        $resources_shortexam_result = mysqli_query($con, "SELECT * FROM resource WHERE course = '" . mysqli_real_escape_string($con, $_GET['course']) . "' AND type = 'Short Exam'");
        $resources_powerpoint_result = mysqli_query($con, "SELECT * FROM resource WHERE course = '" . mysqli_real_escape_string($con, $_GET['course']) . "' AND type = 'Powerpoint'");
        $resources_workingpaper_result = mysqli_query($con, "SELECT * FROM resource WHERE course = '" . mysqli_real_escape_string($con, $_GET['course']) . "' AND type = 'Working Paper'");
        $resources_video_result = mysqli_query($con, "SELECT * FROM resource WHERE course = '" . mysqli_real_escape_string($con, $_GET['course']) . "' AND type = 'Video'");
        $resources_book_result = mysqli_query($con, "SELECT * FROM resource WHERE course = '" . mysqli_real_escape_string($con, $_GET['course']) . "' AND type = 'Book'");
        $resources_article_result = mysqli_query($con, "SELECT * FROM resource WHERE course = '" . mysqli_real_escape_string($con, $_GET['course']) . "' AND type = 'Article'");
        $resources_lecture_result = mysqli_query($con, "SELECT * FROM resource WHERE course = '" . mysqli_real_escape_string($con, $_GET['course']) . "' AND type = 'Lecture'");
        
        $resource_types = [
            'Research' => $resources_research_result,
            'Short Exam' => $resources_shortexam_result,
            'Powerpoint' => $resources_powerpoint_result,
            'Working Paper' => $resources_workingpaper_result,
            'Video' => $resources_video_result,
            'Book' => $resources_book_result,
            'Article' => $resources_article_result,
            'Lecture' => $resources_lecture_result
        ];
        
        foreach ($resource_types as $type => $result) {
            $tab_id = 'tabs-' . str_replace(' ', '-', $type);
            $icon = getResourceIcon($type);
            $color = getResourceColor($type);
        ?>
        <div id="<?php echo $tab_id; ?>">
            <div class="resource-grid">
                <?php while ($resource = mysqli_fetch_assoc($result)) { ?>
                <div class="resource-card" data-type="<?php echo $type; ?>">
                    <div class="resource-icon" style="background-color: <?php echo $color; ?>">
                        <i class="bi <?php echo $icon; ?>"></i>
                    </div>
                    <div class="resource-content">
                        <h3><?php echo htmlspecialchars($resource['title']); ?></h3>
                        <p class="resource-meta">
                            <span class="resource-type" style="color: <?php echo $color; ?>">
                                <?php echo $type; ?>
                            </span>
                            • <?php echo date('M d, Y', strtotime($resource['date'])); ?>
                        </p>
                        <p class="resource-desc"><?php echo htmlspecialchars($resource['description']); ?></p>
                        <div class="resource-actions">
                            <a href="show_resource_comments_rates.php?id=<?php echo $resource['id']; ?>" class="btn-comments">
                                <i class="bi bi-chat-left-text"></i> Comments
                            </a>
                            <?php if ($_SESSION['user_type'] == "student" || $_SESSION['user_type'] == "member") { ?>
                                <a href="assets/resources/<?php echo $resource['file']; ?>" target="_blank" class="btn-download">
                                    <i class="bi bi-download"></i> Download
                                </a>
                            <?php } else { ?>
                                <span class="download-restricted">Download for students</span>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php
// Helper functions for icons and colors
function getResourceIcon($type) {
    switch($type) {
        case 'Research': return 'bi-file-earmark-text';
        case 'Short Exam': return 'bi-file-earmark-check';
        case 'Powerpoint': return 'bi-file-earmark-slides';
        case 'Working Paper': return 'bi-file-earmark-richtext';
        case 'Video': return 'bi-film';
        case 'Book': return 'bi-book';
        case 'Article': return 'bi-newspaper';
        case 'Lecture': return 'bi-easel';
        default: return 'bi-file-earmark';
    }
}

function getResourceColor($type) {
    switch($type) {
        case 'Research': return '#3498db';
        case 'Short Exam': return '#e74c3c';
        case 'Powerpoint': return '#9b59b6';
        case 'Working Paper': return '#f39c12';
        case 'Video': return '#1abc9c';
        case 'Book': return '#2ecc71';
        case 'Article': return '#e67e22';
        case 'Lecture': return '#34495e';
        default: return '#7f8c8d';
    }
}

include 'footer.php';
?>