# LogWhisperer (PHP CLI + AI)

An AI-powered command-line tool that reads messy server error logs and outputs clean, categorized solutions using LLM Function Calling. Built with PHP and powered by Groq's API.

## Team Members
* Dawson Brown
* Jeremy Paruch
* Josh Leslie
* Judah Csanyi

## Features
- 🤖 AI-powered log analysis using Groq's Llama 3.3 70B model
- 📊 Structured JSON output with error detection, severity classification, cause analysis, and solutions
- 🎨 Color-coded terminal output for easy readability
- ✅ Input validation and error handling
- 🧪 Test log files included for demonstration

## Project Structure
```
LogWhisperer/
├── README.md                 # Project documentation
├── whisper.php              # Main CLI application entry point
├── api_handler.php          # Groq API communication handler
├── php.ini                  # PHP configuration file
├── .gitignore               # Git ignore rules
├── data/                    # Test log files
│   ├── test.log            # Small test log file
│   ├── mediumTest.log      # Medium-sized test log file
│   └── largeTest.log       # Large test log file
└── docs/                    # Project documentation and presentations
    ├── LearningGuide.docx             # Technical learning guide
    └── LogWhisperer-POWERPOINT-V1.1.pptx  # Project presentation
```

## File Descriptions

### Core Application Files
- **whisper.php**: Main CLI application that orchestrates the log analysis workflow
  - Loads environment variables and API key
  - Reads log files from command line arguments
  - Formats the request for Groq API
  - Parses and displays AI-generated analysis with color-coded output

- **api_handler.php**: Handles all communication with Groq's API
  - `sendToGroq()` function sends formatted log data to the Groq API
  - Manages HTTP headers, authentication, and SSL configuration
  - Returns parsed JSON response from the AI model

- **php.ini**: PHP configuration file for CLI environment settings

### Data Directory (`/data`)
Contains sample log files for testing:
- **test.log**: Small test file for quick testing
- **mediumTest.log**: Medium-sized log file for standard testing
- **largeTest.log**: Large log file for performance testing

### Docs Directory (`/docs`)
Contains project documentation:
- **LearningGuide.docx**: Comprehensive technical guide covering implementation details
- **LogWhisperer-POWERPOINT-V1.1.pptx**: Project presentation with overview and demos

## Setup Instructions (Development)

### Prerequisites
1. Install PHP 8.x CLI
2. Obtain a Groq API key (free tier available at https://console.groq.com)

### Installation Steps
1. Clone this repository:
   ```bash
   git clone https://github.com/NamekianLegend/Final-Project-Emerging-Tech-PHP-LogWhisperer.git
   cd Final-Project-Emerging-Tech-PHP-LogWhisperer
   ```

2. Create an `.env` file in the project root:
   ```bash
   touch .env
   ```

3. Add your Groq API key to the `.env` file:
   ```
   OPENAI_API_KEY=your_groq_api_key_here
   ```

4. Copy the `php.ini` file to your PHP directory:
   ```bash
   cp php.ini C:\PHP\  # Windows
   # or
   cp php.ini /etc/php/  # Linux/Mac (adjust path as needed)
   ```

5. Run LogWhisperer on a log file:
   ```bash
   php whisper.php /path/to/logfile.log
   ```

### Usage Examples
```bash
# Analyze a small test file
php whisper.php data/test.log

# Analyze a medium-sized log
php whisper.php data/mediumTest.log

# Analyze your own log file
php whisper.php /var/log/error.log
```

### Error Handling
- If no file path is provided: `⚠️ No log file provided. Usage: php whisper.php /path/to/logfile.log`
- If log file doesn't exist: `❌ Log file not found: /path/to/file`
- If API key is missing: `ERROR: API key not found. Please set it in the .env file.`

## Output Format
LogWhisperer analyzes logs and returns:
- **Error Detected**: Summary of the error found
- **Severity**: Classification (Critical, High, Medium, Low, Info)
- **Cause**: Root cause analysis
- **Solution**: Recommended fix or troubleshooting steps

All output is color-coded for easy terminal reading:
- 🟢 Green: Success and solutions
- 🟡 Yellow: Warnings and severity information
- 🔴 Red: Errors
- 🔵 Blue: Processing status
- 🔷 Cyan: Log content display

## Technologies Used
- **Language**: PHP 8.x
- **AI Model**: Groq Llama 3.3 70B (via Groq API)
- **API Format**: OpenAI-compatible REST API
- **Response Format**: JSON with structured fields

## Version
v1.0 - Initial Release
