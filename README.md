# AI Quiz Generator

An intelligent web-based quiz generation system that automatically creates customized multiple-choice questions from uploaded documents using AI technology.

##  Features

### Core Functionality
- **Document Upload**: Support for PDF and DOCX file formats
- **AI-Powered Question Generation**: Automatic MCQ creation using advanced AI models
- **Customizable Parameters**: Adjustable question count (1-100) and difficulty levels (Easy/Medium/Hard)
- **User Management**: Secure registration and login system
- **Real-time Quiz Interface**: Interactive quiz taking with timer functionality
- **Results & Analytics**: Comprehensive scoring and performance tracking

### Security Features
- **Anti-Cheating Measures**: Disabled right-click, copy-paste, and text selection during quizzes
- **Tab Switching Detection**: Automatic submission prevention when switching browser tabs
- **Session Management**: Secure user authentication and session handling

### Technical Features
- **Text Extraction**: Advanced PDF/DOCX text extraction using PyMuPDF and python-docx
- **AI Integration**: OpenAI API integration for intelligent question generation
- **Database Storage**: MySQL database for user data and quiz management
- **Responsive Design**: Mobile-friendly web interface

##  Technology Stack

### Backend
- **PHP 8.x**: Server-side scripting and web application logic
- **MySQL**: Database management system
- **Python 3.x**: AI processing and text extraction

### Frontend
- **HTML5/CSS3**: Modern web interface design
- **JavaScript**: Client-side interactivity and security features

### AI & Libraries
- **OpenAI API**: Question generation and content analysis
- **Sentence Transformers**: Text processing and semantic analysis
- **PyMuPDF (fitz)**: PDF text extraction
- **python-docx**: Word document processing

##  Prerequisites

- **Web Server**: Apache/Nginx with PHP support
- **PHP**: Version 8.0 or higher
- **MySQL**: Version 5.7 or higher
- **Python**: Version 3.8 or higher
- **Composer**: PHP dependency management
- **Pip**: Python package management

##  Installation

### 1. Clone Repository
```bash
git clone https://github.com/Priyanshi-maru/ai_project-.git
cd ai_project-
```

### 2. Database Setup
```sql
-- Create database
CREATE DATABASE ai_quiz;

-- Import schema
-- Run the SQL commands from db/database.sql
```

### 3. Python Environment Setup
```bash
# Create virtual environment
python -m venv venv
venv\Scripts\activate  # Windows
# source venv/bin/activate  # Linux/Mac

# Install dependencies
pip install pymupdf python-docx openai sentence-transformers
```

### 4. Configuration
- Update database credentials in `db.php`
- Configure OpenAI API key in Python scripts
- Set correct Python path in `upload.php`

### 5. Web Server Configuration
- Ensure PHP file uploads are enabled
- Set appropriate file size limits
- Configure virtual host pointing to project root

##  Usage

### For Students
1. **Register/Login**: Create account or sign in
2. **Upload Document**: Select PDF/DOCX file and specify quiz parameters
3. **Take Quiz**: Answer questions within time limit
4. **View Results**: Check scores and detailed feedback

### For Administrators
1. **Access Admin Panel**: Navigate to `/admin/`
2. **Manage Questions**: Add/edit/delete question banks
3. **View Analytics**: Monitor user performance and quiz statistics
4. **Export Data**: Generate CSV reports of quiz results

##  Project Structure

```
ai_project-/
├── index.php              # Main dashboard
├── login.php              # User authentication
├── register.php           # User registration
├── quiz.php               # Quiz interface
├── result.php             # Results display
├── upload.php             # File upload handler
├── db.php                 # Database configuration
├── backend/
│   ├── extract_text.py    # Text extraction logic
│   └── generate_mcq.py    # AI question generation
├── admin/
│   ├── index.php          # Admin dashboard
│   ├── add_question.php   # Question management
│   └── question_banks.php # Question bank interface
├── assets/
│   └── style.css          # CSS styling
├── db/
│   ├── database.sql       # Database schema
│   └── migrations.sql     # Database updates
└── uploads/               # User uploaded files
```

##  Security Considerations

- **Input Validation**: All user inputs are sanitized
- **SQL Injection Prevention**: Prepared statements used throughout
- **XSS Protection**: HTML escaping for user-generated content
- **File Upload Security**: File type and size restrictions
- **Session Security**: Secure session handling and timeout

##  Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.

## Authors

- **Priyanshi Maru and Victoria Vedastus** - *Initial work* - [GitHub Profile](https://github.com/Priyanshi-maru)

## Acknowledgments

- OpenAI for AI question generation capabilities
- PyMuPDF community for PDF processing tools
- PHP and MySQL communities for robust web technologies</content>
<parameter name="filePath">C:\Users\Victoria\Downloads\ai_quiz_project (2) (2)\ai_project-\README.md
