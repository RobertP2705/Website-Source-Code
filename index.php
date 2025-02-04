<?php 
require 'vendor/autoload.php';
require 'database.php';

use Illuminate\Database\Capsule\Manager as Capsule;

session_start();

$error = '';
$success = '';

$reviews = Capsule::table('reviews')->orderBy('created_at', 'desc')->get();

$averageScore = Capsule::table('reviews')->avg('rating');
$averageScore = number_format($averageScore, 1);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['password']) && $_POST['password'] === 'welcome2rob!') {
        $reviewer_name = $_POST['reviewer_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $company = $_POST['company'] ?? '';
        $rating = $_POST['rating'] ?? 0;
        $review_text = $_POST['review_text'] ?? '';
        $relation_to_robert = $_POST['relation_to_robert'] ?? '';
        $degree = $_POST['degree'] ?? '';

        if ($reviewer_name && $rating && $review_text) {
            Capsule::table('reviews')->insert([
                'reviewer_name' => $reviewer_name,
                'email' => $email,
                'company' => $company,
                'rating' => $rating,
                'review_text' => $review_text,
                'relation_to_robert' => $relation_to_robert,
                'degree' => $degree,
                'created_at' => Capsule::raw('CURRENT_TIMESTAMP'),
                'updated_at' => Capsule::raw('CURRENT_TIMESTAMP')
            ]);
            $success = 'Review submitted successfully!';
            $reviews = Capsule::table('reviews')->orderBy('created_at', 'desc')->get();
            $averageScore = Capsule::table('reviews')->avg('rating');
            $averageScore = number_format($averageScore, 1);
        } else {
            $error = 'Please fill in all required fields.';
        }
    } else {
        $error = 'Incorrect password';
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Robert Prevost - Software Engineer</title>
    <link rel="icon" type="image/x-icon" href="atom.png">
    <style>
        :root {
            --primary-color: #2C3E50;
            --secondary-color: #3498DB;
            --accent-color: #E74C3C;
            --text-color: #2C3E50;
            --bg-color: #FFFFFF;
            --section-bg: #F8F9FA;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--bg-color);
        }

        header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 4rem 0;
            text-align: center;
        }

        .header-content {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }
        .academic-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem;
        }

        .semester-card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .semester-header {
            background: #f8f9fa;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e9ecef;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .semester-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2C3E50;
        }

        .achievement-badge {
            background: #d4edda;
            color: #155724;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .course-list {
            padding: 1.5rem;
        }

        .course-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e9ecef;
        }

        .course-item:last-child {
            border-bottom: none;
        }

        .course-info {
            flex: 1;
        }

        .course-code {
            font-weight: 600;
            color: #2C3E50;
            margin-right: 0.5rem;
        }

        .course-name {
            color: #6c757d;
        }

        .course-grade {
            font-weight: 600;
            min-width: 40px;
            text-align: center;
        }

        .grade-a {
            color: #28a745;
        }

        .grade-b {
            color: #ffc107;
        }

        .in-progress {
            color: #6c757d;
            font-style: italic;
        }

        .academic-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .program-title {
            font-size: 1.5rem;
            color: #2C3E50;
            margin-bottom: 0.5rem;
        }

        .institution {
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .current-gpa {
            font-size: 1.25rem;
            font-weight: 600;
            color: #3498DB;
        }
        #portrait {
            width: 180px;
            height: 180px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        nav {
            background: white;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            gap: 2rem;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }

        nav a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: var(--secondary-color);
        }

        main {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 20px;
        }

        section {
            margin-bottom: 4rem;
        }

        .section-title {
            font-size: 2rem;
            margin-bottom: 2rem;
            color: var(--primary-color);
            text-align: center;
        }

        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .project-card {
            background: var(--section-bg);
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .project-card:hover {
            transform: translateY(-5px);
        }

        .project-content {
            padding: 1.5rem;
        }

        .project-title {
            font-size: 1.25rem;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }

        .project-description {
            color: #666;
            margin-bottom: 1rem;
        }

        .project-tech {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .tech-tag {
            background: var(--primary-color);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.875rem;
        }

        .video-container {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            border-radius: 8px;
            margin: 1rem 0;
        }

        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .review-section {
            background: var(--section-bg);
            padding: 2rem;
            border-radius: 8px;
            margin-top: 2rem;
        }

        .review-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .rating {
            color: var(--accent-color);
            font-weight: bold;
        }

        .average-score {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 2rem;
            color: var(--primary-color);
        }

        .contact-info {
            text-align: center;
            margin-top: 1rem;
            color: white;
        }

        .contact-info a {
            color: white;
            text-decoration: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }

        @media (max-width: 768px) {
            nav ul {
                flex-direction: column;
                align-items: center;
                gap: 1rem;
            }

            .project-grid {
                grid-template-columns: 1fr;
            }

            header {
                padding: 2rem 0;
            }

            #portrait {
                width: 150px;
                height: 150px;
            }
        }

        .document-links {
            margin-top: 1.5rem;
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .doc-button {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .doc-button:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        .enterprise-project {
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: rgba(44, 62, 80, 0.05);
            border-radius: 6px;
        }

        .enterprise-project h4 {
            color: var(--primary-color);
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .enterprise-project p {
            color: #666;
            line-height: 1.5;
            margin: 0;
        }

        .project-tech {
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <img id="portrait" src="robert_portrait.jpg" alt="Robert Prevost">
            <h1>Robert Prevost</h1>
            <p class="contact-info">
                Hoffman Estates, IL | 
                <a href="mailto:prevostrobert309@gmail.com">prevostrobert309@gmail.com</a> |
                <a href="https://github.com/RobertP2705?tab=repositories">GitHub</a>
            </p>
            <div class="document-links">
                <a href="resume.pdf" class="doc-button" download>Download Resume</a>
                <a href="transcript.pdf" class="doc-button" download>Download Transcript</a>
            </div>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="#projects">Projects</a></li>
            <li><a href="#work-experience">Professional Work</a></li>
            <li><a href="#reviews">Reviews</a></li>
            <li><a href="#courseload">Academic Background</a></li>
        </ul>
    </nav>

    <main>
        <section id="projects">
            <h2 class="section-title">Featured Projects</h2>
               
            <div class="project-grid">
                <div class="project-card">
                        <div class="project-content">
                            <h3 class="project-title">Nuclear Physics System</h3>
                            <p class="project-description">A Roblox physics engine implementation inspired by Rutherford's Atomic Model, utilizing Coulomb's law for electric force and a modified Yukawa Potential function for nuclear force calculations. (Code can be found in my GitHub Repository: <a href = 'https://github.com/RobertP2705/Nuclear-Physics-System?tab=readme-ov-file'>Repo</a>)</p>
                            <div class="video-container">
                                <iframe src="https://www.youtube.com/embed/AYUHqdrj1d8" allowfullscreen></iframe>
                            </div>
                            <div class="project-tech">
                                <span class="tech-tag">Luau</span>
                                <span class="tech-tag">Physics</span>
                                <span class="tech-tag">Roblox Studio</span>
                            </div>
                        </div>
                    </div>
                <div class="project-card">
                    <div class="project-content">
                        <h3 class="project-title">Physics Solver</h3>
                        <p class="project-description">An interactive application for solving physics problems, featuring a graphical interface and complex calculations. (Code can be found in my GitHub Repository: <a href = 'https://github.com/RobertP2705/Physics-Solver'>Repo</a>)</p>
                        <div class="video-container">
                            <iframe src="https://www.youtube.com/embed/LoJ5d3QV1IY" allowfullscreen></iframe>
                        </div>
                        <div class="project-tech">
                            <span class="tech-tag">Python</span>
                            <span class="tech-tag">Pygame</span>
                            <span class="tech-tag">Physics</span>
                        </div>
                    </div>
                </div>

                <div class="project-card">
                    <div class="project-content">
                        <h3 class="project-title">Roblox Game Development</h3>
                        <p class="project-description">Created multiple games with over 22,000 combined visits. Comprosing months of mostly coding with some game and UI design. Full of complex datastores, leaderboard systems, point systems, purchasing systems, inventories, shops, combat and many more.</p>
                        <ul>
                            <li><a href="https://www.roblox.com/games/17649210238/Greek-Dungeon-RNG-early-alpha" target="_blank">Greek Dungeon RNG</a></li>
                            <li><a href="https://www.roblox.com/games/17613237654/Easy-Skibidi-Meme-Obby-100-Stages" target="_blank">Skibidi Meme Obby</a></li>
                            <li><a href="https://www.roblox.com/games/122604291698042/MASS-UNFOLLOW-VEXBOLTS-UPD" target="_blank">Mass Unfollow Vexbolts Game</a></li>
                        </ul>
                        <div class="project-tech">
                            <span class="tech-tag">Luau</span>
                            <span class="tech-tag">Game Design</span>
                            <span class="tech-tag">Roblox Studio</span>
                        </div>
                    </div>
                </div>

                <div class="project-card">
                    <div class="project-content">
                        <h3 class="project-title">Portfolio Website</h3>
                        <p class="project-description">A full-stack web application showcasing my projects and skills, built entirely from scratch. (Code can be found in my GitHub Repository: <a href = 'https://github.com/RobertP2705/Website-Source-Code'>Repo</a>)</p>
                        <div class="project-tech">
                            <span class="tech-tag">HTML</span>
                            <span class="tech-tag">CSS</span>
                            <span class="tech-tag">JavaScript</span>
                            <span class="tech-tag">PHP</span>
                            <span class="tech-tag">PostgreSQL</span>
                        </div>
                    </div>
                </div>
                
            </div>
        </section>

        <section id="work-experience">
    <h2 class="section-title">Professional Work</h2>
    <div class="project-card">
        <div class="project-content">
            <h3 class="project-title">Enterprise Software Development</h3>
            <p class="project-description">Lead Software Developer at Lake Cable LLC, delivering mission-critical applications that enhance manufacturing operations and data management:</p>
            <div class="enterprise-project">
                <h4>Operator Information Dashboard (~3,000 LOC)</h4>
                <p>Enterprise-wide web application deployed across all manufacturing plants, serving thousands of daily users. Provides real-time work order management, job tracking, and machine status monitoring. Built with advanced CSS/HTML frontend and robust backend integration, significantly improving operational workflow efficiency.</p>
            </div>
            <div class="enterprise-project">
                <h4>Calibration System (~5,000-10,000 LOC)</h4>
                <p>Comprehensive tool management platform featuring advanced data collection and metrics tracking. Includes sophisticated search functionality for accessing tool specifications, measurement data, and calibration histories, ensuring consistent quality control across operations.</p>
            </div>
            <div class="enterprise-project">
                <h4>Real-time Production Monitoring System</h4>
                <p>Plant-wide production visualization system displayed on facility-wide screens, providing shift supervisors with instant visibility into production line status and work order progress. Features responsive design that optimizes data presentation across various display sizes.</p>
            </div>
            <div class="enterprise-project">
                <h4>Advanced SQL Database Conversion</h4>
                <p>Leading a 12-week database modernization initiative implementing system-versioned tables across the infrastructure. Project involves comprehensive query optimization and schema updates to enable robust historical data tracking while maintaining system integrity.</p>
            </div>
            <div class="enterprise-project">
                <h4>SQL Database Migration</h4>
                <p>A separate project from the Database Conversion project. Required moving databases from mySQL to SQL server for centralized and optimized database procedures. Required in-depth CTE and temporal table conversions for specified tables.</p>
            </div>               
            <div class="project-tech">
                <span class="tech-tag">PHP</span>
                <span class="tech-tag">JavaScript</span>
                <span class="tech-tag">SQL</span>
                <span class="tech-tag">HTML/CSS</span>
                <span class="tech-tag">Database Design</span>
            </div>
        </div>
    </div>
        </section>

        <section id="reviews">
    <h2 class="section-title">Reviews</h2>
    
            <div class="review-section">
                <div class="average-score">
                    Average Rating: <?php echo $averageScore; ?> / 5
                </div>

                <?php foreach ($reviews as $review): ?>
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <strong><?php echo htmlspecialchars($review->reviewer_name); ?></strong>
                                <?php if ($review->company): ?>
                                    <span> - <?php echo htmlspecialchars($review->company); ?></span>
                                <?php endif; ?>
                            </div>
                            <div class="rating">
                                <?php echo $review->rating; ?>/5
                            </div>
                        </div>
                        <p><?php echo nl2br(htmlspecialchars($review->review_text)); ?></p>
                        <?php if ($review->relation_to_robert): ?>
                            <p><small>Relation: <?php echo htmlspecialchars($review->relation_to_robert); ?></small></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>

                <div style="text-align: center; margin-top: 2rem;">
                    <a href="submit_review.php" class="submit-button" style="text-decoration: none;">Submit a Review</a>
                </div>
            </div>
        </section>
        <section id="courseload">
            <div class="academic-container">
                <div class="academic-header">
                    <h3 class="program-title">Engineering Pathways Program</h3>
                    <p class="institution">Harper College / University of Illinois at Urbana-Champaign</p>
                    <p class="current-gpa">Current GPA: 3.9</p>
                </div>

                <?php
                $semesters = [
                    [
                        'term' => 'Fall 2023',
                        'achievement' => "President's List",
                        'courses' => [
                            ['code' => 'CHM 121', 'name' => 'General Chemistry I (Honors)', 'grade' => 'A'],
                            ['code' => 'CSC 121', 'name' => 'Computer Science I', 'grade' => 'A'],
                            ['code' => 'ECO 211', 'name' => 'Microeconomics', 'grade' => 'A'],
                            ['code' => 'EGR 100', 'name' => 'Introduction to Engineering', 'grade' => 'A'],
                            ['code' => 'MTH 200', 'name' => 'Calculus I', 'grade' => 'A']
                        ]
                    ],
                    [
                        'term' => 'Spring 2024',
                        'achievement' => "Dean's List",
                        'courses' => [
                            ['code' => 'CHM 122', 'name' => 'General Chemistry II', 'grade' => 'A'],
                            ['code' => 'MTH 201', 'name' => 'Calculus II', 'grade' => 'B'],
                            ['code' => 'PHI 205', 'name' => 'Religions of the World (Honors)', 'grade' => 'A'],
                            ['code' => 'PHY 201', 'name' => 'General Physics I: Mechanics', 'grade' => 'A']
                        ]
                    ],
                    [
                        'term' => 'Fall 2024',
                        'achievement' => "President's List",
                        'courses' => [
                            ['code' => 'CSC 122', 'name' => 'Computer Science II', 'grade' => 'A'],
                            ['code' => 'EGR 210', 'name' => 'Analytical Mechanics/Statics', 'grade' => 'A'],
                            ['code' => 'MTH 202', 'name' => 'Calculus III', 'grade' => 'A'],
                            ['code' => 'PHY 202', 'name' => 'General Physics II: E&M', 'grade' => 'A']
                        ]
                    ],
                    [
                        'term' => 'Spring 2025',
                        'inProgress' => true,
                        'courses' => [
                            ['code' => 'CIS 245', 'name' => 'Data Analysis'],
                            ['code' => 'CSC 216', 'name' => 'Data Structures & Algorithm Analysis'],
                            ['code' => 'MTH 203', 'name' => 'Linear Algebra'],
                            ['code' => 'MTH 220', 'name' => 'Discrete Mathematics'],
                            ['code' => 'MUS 103', 'name' => 'Music Appreciation']
                        ]
                    ]
                ];

                foreach ($semesters as $semester): ?>
                    <div class="semester-card">
                        <div class="semester-header">
                            <h4 class="semester-title">
                                <?php echo $semester['term']; ?>
                                <?php if (isset($semester['inProgress'])): ?>
                                    (In Progress)
                                <?php endif; ?>
                            </h4>
                            <?php if (isset($semester['achievement'])): ?>
                                <span class="achievement-badge">🏆 <?php echo $semester['achievement']; ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="course-list">
                            <?php foreach ($semester['courses'] as $course): ?>
                                <div class="course-item">
                                    <div class="course-info">
                                        <span class="course-code"><?php echo $course['code']; ?></span>
                                        <span class="course-name"><?php echo $course['name']; ?></span>
                                    </div>
                                    <?php if (isset($course['grade'])): ?>
                                        <span class="course-grade <?php echo $course['grade'] === 'A' ? 'grade-a' : 'grade-b'; ?>">
                                            <?php echo $course['grade']; ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="course-grade in-progress">In Progress</span>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <script>
        document.querySelectorAll('nav a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>