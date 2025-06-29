<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create CV</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="create_cv.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">CV Generator</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0" style="gap: 1.5rem;">
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><span class="nav-link">Hey <?php echo htmlspecialchars($_SESSION['username']); ?></span></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="download.php">Download</a></li>
                    <li class="nav-item"><a class="nav-link" href="AboutUs.php">About</a></li>
                    <li class="nav-item"><a class="nav-link active" href="create_cv.php">Create</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <!-- CV Form Start -->
        <div class="cv-form-container">
            <form id="cvForm" method="post" action="CV.php" target="_blank">
                <!-- Header Section -->
                <div class="form-header">
                    <h1>Curriculum Vitae</h1>
                    <p class="text-muted">Fill in your details to generate a professional CV</p>
                </div>
                <!-- Personal Information Section -->
                <div class="section-title">Personal Information</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firstName" class="form-label">First Name*</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="lastName" class="form-label">Last Name*</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">Email*</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="form-label">Phone Number*</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="linkedin" class="form-label">LinkedIn Profile</label>
                            <input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="https://linkedin.com/in/yourprofile">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="professionalSummary" class="form-label">Professional Summary</label>
                            <textarea class="form-control" id="professionalSummary" name="professionalSummary" placeholder="Briefly describe your professional background and key skills"></textarea>
                        </div>
                    </div>
                </div>
                <!-- Work Experience Section -->
                <div class="section-title">Work Experience</div>
                <div id="workExperienceContainer">
                    <div class="work-experience-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jobTitle1" class="form-label">Job Title*</label>
                                    <input type="text" class="form-control" id="jobTitle1" name="jobTitle[]" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="company1" class="form-label">Company*</label>
                                    <input type="text" class="form-control" id="company1" name="company[]" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="location1" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location1" name="location[]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="date-input-group">
                                    <div class="form-group date-input">
                                        <label for="startDate1" class="form-label">Start Date*</label>
                                        <input type="date" class="form-control" id="startDate1" name="startDate[]" required>
                                    </div>
                                    <div class="form-group date-input">
                                        <label for="endDate1" class="form-label">End Date (or leave blank if current)</label>
                                        <input type="date" class="form-control" id="endDate1" name="endDate[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="jobDescription1" class="form-label">Job Description*</label>
                            <textarea class="form-control" id="jobDescription1" name="jobDescription[]" required placeholder="Describe your responsibilities and achievements"></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success add-btn" id="addWorkExperience">+ Add Another Position</button>
                <!-- Education Section -->
                <div class="section-title">Education</div>
                <div id="educationContainer">
                    <div class="education-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="degree1" class="form-label">Degree/Certification*</label>
                                    <input type="text" class="form-control" id="degree1" name="degree[]" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="institution1" class="form-label">Institution*</label>
                                    <input type="text" class="form-control" id="institution1" name="institution[]" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="educationLocation1" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="educationLocation1" name="educationLocation[]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="date-input-group">
                                    <div class="form-group date-input">
                                        <label for="educationStartDate1" class="form-label">Start Date*</label>
                                        <input type="date" class="form-control" id="educationStartDate1" name="educationStartDate[]" required>
                                    </div>
                                    <div class="form-group date-input">
                                        <label for="educationEndDate1" class="form-label">End Date (or expected)</label>
                                        <input type="date" class="form-control" id="educationEndDate1" name="educationEndDate[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="educationDescription1" class="form-label">Description</label>
                            <textarea class="form-control" id="educationDescription1" name="educationDescription[]" placeholder="Any honors, awards, or relevant coursework"></textarea>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success add-btn" id="addEducation">+ Add Another Education</button>
                <!-- Skills Section -->
                <div class="section-title">Skills</div>
                <div class="form-group">
                    <label for="skillsInput" class="form-label">Add Skills (separate with commas)</label>
                    <input type="text" class="form-control" id="skillsInput" name="skillsInput" placeholder="e.g., Project Management, JavaScript, Public Speaking">
                    <div id="skillsDisplay" class="mt-2"></div>
                </div>
                <!-- Projects Section -->
                <div class="section-title">Projects</div>
                <div id="projectsContainer">
                    <div class="project-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="projectName1" class="form-label">Project Name*</label>
                                    <input type="text" class="form-control" id="projectName1" name="projectName[]" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="projectRole1" class="form-label">Your Role</label>
                                    <input type="text" class="form-control" id="projectRole1" name="projectRole[]">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="projectDescription1" class="form-label">Project Description*</label>
                            <textarea class="form-control" id="projectDescription1" name="projectDescription[]" required placeholder="Describe the project and your contributions"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="projectUrl1" class="form-label">Project URL (if applicable)</label>
                            <input type="url" class="form-control" id="projectUrl1" name="projectUrl[]">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success add-btn" id="addProject">+ Add Another Project</button>
                <!-- Certifications Section -->
                <div class="section-title">Certifications</div>
                <div id="certificationsContainer">
                    <div class="certification-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="certificationName1" class="form-label">Certification Name*</label>
                                    <input type="text" class="form-control" id="certificationName1" name="certificationName[]" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="certificationOrg1" class="form-label">Issuing Organization*</label>
                                    <input type="text" class="form-control" id="certificationOrg1" name="certificationOrg[]" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="certificationDate1" class="form-label">Date Earned</label>
                                    <input type="date" class="form-control" id="certificationDate1" name="certificationDate[]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="certificationUrl1" class="form-label">Credential URL (if applicable)</label>
                                    <input type="url" class="form-control" id="certificationUrl1" name="certificationUrl[]">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success add-btn" id="addCertification">+ Add Another Certification</button>
                <!-- Languages Section -->
                <div class="section-title">Languages</div>
                <div id="languagesContainer">
                    <div class="language-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="language1" class="form-label">Language*</label>
                                    <input type="text" class="form-control" id="language1" name="language[]" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="proficiency1" class="form-label">Proficiency Level*</label>
                                    <select class="form-select" id="proficiency1" name="proficiency[]" required>
                                        <option value="">Select proficiency</option>
                                        <option value="Native">Native</option>
                                        <option value="Fluent">Fluent</option>
                                        <option value="Advanced">Advanced</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Basic">Basic</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success add-btn" id="addLanguage">+ Add Another Language</button>
                <!-- References Section -->
                <div class="section-title">References</div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="referencesAvailable" name="referencesAvailable">
                    <label class="form-check-label" for="referencesAvailable">References available upon request</label>
                </div>
                <div id="referencesContainer" style="display: none;">
                    <div class="reference-item">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="referenceName1" class="form-label">Reference Name*</label>
                                    <input type="text" class="form-control" id="referenceName1" name="referenceName[]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="referenceTitle1" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="referenceTitle1" name="referenceTitle[]">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="referenceCompany1" class="form-label">Company</label>
                                    <input type="text" class="form-control" id="referenceCompany1" name="referenceCompany[]">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="referencePhone1" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="referencePhone1" name="referencePhone[]">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="referenceEmail1" class="form-label">Email</label>
                            <input type="email" class="form-control" id="referenceEmail1" name="referenceEmail[]">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success add-btn" id="addReference" style="display: none;">+ Add Another Reference</button>
                <!-- Form Submission -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="reset" class="btn btn-secondary me-md-2">Reset Form</button>
                    <button type="submit" class="btn btn-primary">Generate CV</button>
                </div>
            </form>
        </div>
        <!-- CV Form End -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // This would be expanded with actual form handling logic
        document.getElementById('referencesAvailable').addEventListener('change', function() {
            const refContainer = document.getElementById('referencesContainer');
            const addRefBtn = document.getElementById('addReference');
            if (this.checked) {
                refContainer.style.display = 'none';
                addRefBtn.style.display = 'none';
            } else {
                refContainer.style.display = 'block';
                addRefBtn.style.display = 'block';
            }
        });

        // Skill tags functionality
        document.getElementById('skillsInput').addEventListener('keydown', function(e) {
            if (e.key === ',' || e.key === 'Enter') {
                e.preventDefault();
                const skill = this.value.trim();
                if (skill) {
                    addSkillTag(skill);
                    this.value = '';
                }
            }
        });

        function addSkillTag(skill) {
            const container = document.getElementById('skillsDisplay');
            const tag = document.createElement('span');
            tag.className = 'skill-tag';
            tag.innerHTML = `${skill} <span class="remove-skill" style="cursor:pointer;">×</span>`;
            container.appendChild(tag);
            
            tag.querySelector('.remove-skill').addEventListener('click', function() {
                tag.remove();
            });
        }

        // Add more items functionality would be implemented here
        // For example, adding more work experience sections:
        let workExpCount = 1;
        document.getElementById('addWorkExperience').addEventListener('click', function() {
            workExpCount++;
            const newItem = document.createElement('div');
            newItem.className = 'work-experience-item mt-4';
            newItem.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="jobTitle${workExpCount}" class="form-label">Job Title*</label>
                            <input type="text" class="form-control" id="jobTitle${workExpCount}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="company${workExpCount}" class="form-label">Company*</label>
                            <input type="text" class="form-control" id="company${workExpCount}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="location${workExpCount}" class="form-label">Location</label>
                            <input type="text" class="form-control" id="location${workExpCount}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="date-input-group">
                            <div class="form-group date-input">
                                <label for="startDate${workExpCount}" class="form-label">Start Date*</label>
                                <input type="date" class="form-control" id="startDate${workExpCount}" required>
                            </div>
                            <div class="form-group date-input">
                                <label for="endDate${workExpCount}" class="form-label">End Date (or leave blank if current)</label>
                                <input type="date" class="form-control" id="endDate${workExpCount}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="jobDescription${workExpCount}" class="form-label">Job Description*</label>
                    <textarea class="form-control" id="jobDescription${workExpCount}" required placeholder="Describe your responsibilities and achievements"></textarea>
                </div>
                <button type="button" class="btn btn-danger remove-btn remove-work-exp">Remove</button>
            `;
            document.getElementById('workExperienceContainer').appendChild(newItem);
            
            // Add event listener for the remove button
            newItem.querySelector('.remove-work-exp').addEventListener('click', function() {
                newItem.remove();
            });
        });

        // Similar implementations would be needed for other sections (education, projects, etc.)
    </script>
</body>
</html> 