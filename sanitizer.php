<?php            // sanitizer.php
return [
    'sensitivePatterns' => [
        // credentials
        '/(?i)\bpassword\s*[:=]\s*(["\']?)[^"\']+\1/', //password="123"
        '/(?i)\bpassword\s*[:=]\s*(["\']?).+?\1\b/',
        '/(?i)\bpassword\s*[:=]\s*\S+/',          // password = secret123
        '/(?i)\bpwd\s*[:=]\s*\S+/',               // pwd = abc
        '/\b(?:pass\w*|pwd\w*)\s*[:=]\s*\S+/i',  // Matches any password-like assignment
        '/(?i)\bpassphrase\s*[:=]\s*\S+/',        // passphrase: ...
        '/(?i)\btoken\s*[:=]\s*\S+/',             // token = xyz
        '/(?i)\bbearer\s+[A-Za-z0-9._\-]+/',      // Bearer eyJhbGciOiJI…
        // common API / cloud keys
        '/(?i)\bapi[_-]?key\s*[:=]\s*\S+/',
        '/\bAWS[A-Z0-9]{16,40}\b/',
        '/(?i)\bsecret[_-]?access[_-]?key\s*[:=]\s*\S+/',
        // typical ID / hash / token shapes
        '/\b[A-Za-z0-9\-_]{40,}\b/',
        '/\beyJ[A-Za-z0-9._-]{20,}\b/',
        // personally‑identifiable info (PII)
        '/\b\d{3}-\d{2}-\d{4}\b/',               
        '/\b(?:\d[ -]*?){13,19}\b/',              
        '/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/i', 
        '/\b\d{10}\b/',                           
        // env
        '/(?i)^\s*(APP_KEY|API[_-]?KEY|SECRET|TOKEN|AUTH_TOKEN|JWT[_-]?SECRET|ACCESS[_-]?TOKEN)\s*=\s*(["\']?).+?\2\s*$/m',
        '/(?i)^\s*(DB_PASSWORD|DATABASE_PASSWORD|MYSQL_ROOT_PASSWORD|POSTGRES_PASSWORD)\s*=\s*(["\']?).+?\2\s*$/m',
        '/(?i)^\s*(MAIL_PASSWORD|SMTP_PASSWORD|EMAIL_PASSWORD)\s*=\s*(["\']?).+?\2\s*$/m',
        '/(?i)^\s*(AWS[_-]?SECRET[_-]?ACCESS[_-]?KEY|AWS_SECRET_KEY)\s*=\s*(["\']?).+?\2\s*$/m',
        '/(?i)^\s*(AWS[_-]?ACCESS[_-]?KEY[_-]?ID)\s*=\s*(["\']?).+?\2\s*$/m',
        '/(?i)^\s*(STRIPE[_-]?SECRET[_-]?KEY|STRIPE[_-]?API[_-]?KEY)\s*=\s*(["\']?).+?\2\s*$/m',
        '/(?i)^\s*(SENDGRID_API_KEY|MAILGUN_SECRET|TWILIO_AUTH_TOKEN|SLACK_WEBHOOK_URL)\s*=\s*(["\']?).+?\2\s*$/m',
        // Generic fallback: lines with any key including "SECRET", "PASSWORD", or "TOKEN"
        '/(?i)^\s*\w*(SECRET|PASSWORD|TOKEN)\w*\s*=\s*(["\']?).+?\2\s*$/m',
        // JWT or Base64 strings (starting with "eyJ..." or "base64:")
        '/\beyJ[A-Za-z0-9._-]{20,}\b/',       // JWT
        '/\bbase64:[A-Za-z0-9+\/=]{10,}\b/',  // Laravel-style base64 keys
        // 40+ character hash-style values
        '/\b[A-Za-z0-9\-_]{40,}\b/',
        '/[0-9a-z]+\.execute-api\.[0-9a-z._-]+\.amazonaws\.com/',        // AWS API Gateway
        '/AKIA[0-9A-Z]{16}/',                                            // AWS API Key
        '/arn:aws:[a-z0-9-]+:[a-z]{2}-[a-z]+-[0-9]+:[0-9]+:.+/',         // AWS ARN
        '/(A3T[A-Z0-9]|AKIA|AGPA|AROA|AIPA|ANPA|ANVA|ASIA)[A-Z0-9]{16}/', // AWS Access Key ID Value
        '/da2-[a-z0-9]{26}/',                                            // AWS AppSync GraphQL Key
        '/ec2-[0-9a-z._-]+\.compute(-1)?\.amazonaws\.com/',              // AWS EC2 External
        '/[0-9a-z._-]+\.compute(-1)?\.internal/',                        // AWS EC2 Internal
        '/[0-9a-z._-]+\.elb\.amazonaws\.com/',                           // AWS ELB
        '/[0-9a-z._-]+\.cache\.amazonaws\.com/',                         // AWS ElasticCache
        '/mzn\.mws\.[0-9a-f\-]{36}/',                                    // AWS MWS ID
        '/amzn\.mws\.[0-9a-f\-]{36}/',                                   // AWS MWS key
        '/[0-9a-z._-]+\.rds\.amazonaws\.com/',                           // AWS RDS
        '/s3:\/\/[0-9a-z._\/-]+/',                                       // AWS S3 Bucket
        '/(aws_access_key_id|aws_secret_access_key)/',                  // AWS credentials file
        '/(?:abbysale).{0,40}\b([a-zA-Z0-9]{40})\b/',                    // Abbysale
        '/(?:abstract).{0,40}\b([0-9a-z]{32})\b/',                       // Abstract
        '/(?:abuseipdb).{0,40}\b([a-z0-9]{80})\b/',                      // Abuseipdb
        '/(?:accuweather).{0,40}([a-zA-Z0-9%]{35})\b/',                  // Accuweather
        '/\b(aio\_[a-zA-Z0-9]{28})\b/',                                  // Adafruitio
        '/(?:adobe).{0,40}\b([a-z0-9]{32})\b/',                          // Adobeio
        '/(?:adzuna).{0,40}\b([a-z0-9]{8})\b/',                          // Adzuna 1
        '/(?:adzuna).{0,40}\b([a-z0-9]{32})\b/',                         // Adzuna 2
        '/(?:aeroworkflow).{0,40}\b([0-9]+)\b/',                         // Aeroworkflow 1
        '/(?:aeroworkflow).{0,40}\b([a-zA-Z0-9^!]{20})\b/',              // Aeroworkflow 2
        '/(?:agora).{0,40}\b([a-z0-9]{32})\b/',                          // Agora
        '/(?:airbrake).{0,40}\b([0-9]{6})\b/',                           // Airbrakeprojectkey 1
        '/(?:airbrake).{0,40}\b([a-zA-Z0-9]{32})\b/',                    // Airbrakeprojectkey 2
        '/(?:airbrake).{0,40}\b([a-zA-Z0-9]{40})\b/',                    // Airbrakeuserkey
        '/(?:airship).{0,40}\b([0-9A-Za-z]{91})\b/',                     // Airship
        '/(?:airvisual).{0,40}\b([a-z0-9-]{36})\b/',                     // Airvisual
        '/(?:alconost).{0,40}\b([0-9A-Za-z]{32})\b/',                    // Alconost
        '/(?:alegra).{0,40}\b([a-z0-9-]{20})\b/',                        // Alegra 1
        '/(?:alegra).{0,40}\b([a-zA-Z0-9.@-]{25,30})\b/',                // Alegra 2
        '/(?:aletheiaapi).{0,40}\b([A-Z0-9]{32})\b/',                    // Aletheiaapi
        '/(?:algolia).{0,40}\b([A-Z0-9]{10})\b/',                        // Algoliaadminkey 1
        '/(?:algolia).{0,40}\b([a-zA-Z0-9]{32})\b/',                     // Algoliaadminkey 2
        '/\b(LTAI[a-zA-Z0-9]{17,21})[\"\' ;\s]*/',                        // Alibaba
        '/(?:alienvault).{0,40}\b([a-z0-9]{64})\b/',                     // Alienvault
        '/(?:allsports).{0,40}\b([0-9a-z]{64})\b/',                      // Allsports
        '/(?:amadeus).{0,40}\b([0-9A-Za-z]{32})\b/',                     // Amadeus 1
        '/(?:amadeus).{0,40}\b([0-9A-Za-z]{16})\b/',                     // Amadeus 2
        '/arn:aws:sns:[a-z0-9\-]+:[0-9]+:[A-Za-z0-9\-_]+/',              // Amazon SNS Topic
        '/(?:ambee).{0,40}\b([0-9a-f]{64})\b/',                          // Ambee
        '/(?:amplitude).{0,40}\b([a-f0-9]{32})/',                        // Amplitudeapikey
        '/(?:apacta).{0,40}\b([a-z0-9-]{36})\b/',                        // Apacta
        '/(?:api2cart).{0,40}\b([0-9a-f]{32})\b/',                       // Api2cart
        '/\b(sk_live_[a-zA-Z0-9-]{93})\b/',                              // Apideck 1
        '/(?:apideck).{0,40}\b([a-zA-Z0-9]{40})\b/',                     // Apideck 2
        '/(?:apiflash).{0,40}\b([a-z0-9]{32})\b/',                       // Apiflash 1
        '/(?:apiflash).{0,40}\b([a-zA-Z0-9\S]{21,30})\b/',               // Apiflash 2
        '/(?:apifonica).{0,40}\b([0-9a-z]{8}-[0-9a-z]{4}-[0-9a-z]{4}-[0-9a-z]{4}-[0-9a-z]{12})\b/',  // Apifonica
        '/\b(apify\_api\_[a-zA-Z0-9-]{36})\b/',                          // Apify
        '/(?:apimatic).{0,40}\b([a-z0-9\S-]{8,32})\b/',                  // Apimatic 1
        '/(?:apimatic).{0,40}\b([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,})\b/',  // Apimatic 2
        '/(?:apiscience).{0,40}\b([a-bA-Z0-9\S]{22})\b/',                // Apiscience
        '/(?:apollo).{0,40}\b([a-zA-Z0-9]{22})\b/',                      // Apollo
        '/(?:appcues).{0,40}\b([0-9]{5})\b/',                            // Appcues 1
        '/(?:appcues).{0,40}\b([a-z0-9-]{36})\b/',                       // Appcues 2
        '/(?:appcues).{0,40}\b([a-z0-9-]{39})\b/',                       // Appcues 3
        '/(?:appfollow).{0,40}\b([0-9A-Za-z]{20})\b/',                   // Appfollow
        '/(?:appsynergy).{0,40}\b([a-z0-9]{64})\b/',                     // Appsynergy
        '/(?:apptivo).{0,40}\b([a-z0-9-]{36})\b/',                       // Apptivo 1
        '/(?:apptivo).{0,40}\b([a-zA-Z0-9-]{32})\b/',                    // Apptivo 2
        '/amzn\.mws\.[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}/',  // AWS MWS Key
        '/[0-9a-z._-]+\.rds\.amazonaws\.com/',                                        // AWS RDS
        '/s3:\/\/[0-9a-z._\/-]+/',                                                    // AWS S3 Bucket
        '/(A3T[A-Z0-9]|AKIA|AGPA|AIDA|AROA|AIPA|ANPA|ANVA|ASIA)[A-Z0-9]{16}/',        // AWS Client ID
        '/(aws_access_key_id|aws_secret_access_key)/',                               // AWS Credential File Info

     
        '/(?:abbysale).{0,40}\b([a-zA-Z0-9]{40})\b/',

        '/(?:abstract).{0,40}\b([0-9a-z]{32})\b/',


        '/(?:abuseipdb).{0,40}\b([a-z0-9]{80})\b/',


        '/(?:accuweather).{0,40}([a-zA-Z0-9%]{35})\b/',

        // AdafruitIO
        '/\b(aio\_[a-zA-Z0-9]{28})\b/',

        // AdobeIO
        '/(?:adobe).{0,40}\b([a-z0-9]{32})\b/',

        // Adzuna
        '/(?:adzuna).{0,40}\b([a-z0-9]{8})\b/',
        '/(?:adzuna).{0,40}\b([a-z0-9]{32})\b/',

        // Aeroworkflow
        '/(?:aeroworkflow).{0,40}\b([0-9]+)\b/',
        '/(?:aeroworkflow).{0,40}\b([a-zA-Z0-9^!]{20})\b/',

        // Agora
        '/(?:agora).{0,40}\b([a-z0-9]{32})\b/',

        // Airbrake Project Keys
        '/(?:airbrake).{0,40}\b([0-9]{6})\b/',                      // Airbrakeprojectkey - 1
        '/(?:airbrake).{0,40}\b([a-zA-Z0-9\-]{32})\b/',             // Airbrakeprojectkey - 2
        '/(?:api2cart).{0,40}\b([0-9a-f]{32})\b/',

        // Apideck
        '/\b(sk_live_[a-zA-Z0-9-]{93})\b/',                            // Apideck - 1
        '/(?:apideck).{0,40}\b([a-zA-Z0-9]{40})\b/',                   // Apideck - 2

        // Apiflash
        '/(?:apiflash).{0,40}\b([a-z0-9]{32})\b/',                     // Apiflash - 1
        '/(?:apiflash).{0,40}\b([a-zA-Z0-9\S]{21,30})\b/',             // Apiflash - 2

        // Apifonica
        '/(?:apifonica).{0,40}\b([0-9a-z]{11}-[0-9a-z]{4}-[0-9a-z]{4}-[0-9a-z]{4}-[0-9a-z]{12})\b/',

        // Apify
        '/\b(apify_api_[a-zA-Z0-9-]{36})\b/',

        // Apimatic
        '/(?:apimatic).{0,40}\b([a-z0-9\S-]{8,32})\b/',                // Apimatic - 1
        '/(?:apimatic).{0,40}\b([a-zA-Z0-9]{3,20}@[a-zA-Z0-9]{2,12}\.[a-zA-Z0-9]{2,5})\b/', // Apimatic - 2

        // Apiscience
        '/(?:apiscience).{0,40}\b([a-bA-Z0-9\S]{22})\b/',
        '/(?:auth0).{0,40}\b(ey[a-zA-Z0-9._-]+)\b/',

        // Auth0 OAuth Token (typical OAuth access_token format, moderate length)
        '/(?:auth0).{0,40}\b([a-zA-Z0-9_-]{32,60})\b/',
        '/(?:bannerbear).{0,40}\b([0-9a-zA-Z]{22}tt)\b/',

        // Baremetrics
        '/(?:baremetrics).{0,40}\b([a-zA-Z0-9_]{25})\b/',

        // Baseapiio
        '/(?:baseapi|base-api).{0,40}\b([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})\b/',

        // Beamer
        '/(?:beamer).{0,40}\b([a-zA-Z0-9_+\/]{45}=)/',

        // Generic Bearer Token (Low confidence, catch-all)
        '/(bearer).+/',
        '/"type":\s*"service_account"/',

        // Google API Key
        '/AIza[0-9a-zA-Z\-_]{35}/',

        // Google Calendar Embed URL
        '/https:\/\/www\.google\.com\/calendar\/embed\?src=[A-Za-z0-9%@&;=\-_.\/]+/',

        // Google OAuth Access Token
        '/ya29\.[0-9A-Za-z\-_]+/',

        // AWS Access Key & Secret
        '/AKIA[0-9A-Z]{16}/',                                      // AWS Access Key ID
        '/ASIA[0-9A-Z]{16}/',                                      // Temporary AWS Access Key
        '/A3T[A-Z0-9]{16}/',                                       // AWS Account ID (special)
        '/(aws_secret_access_key\s*=\s*)[a-zA-Z0-9\/+=]{40}/i',    // AWS Secret Access Key
        '/aws_access_key_id\s*=\s*AKIA[0-9A-Z]{16}/i',             // Access key in config files

        // AWS Session Token (JWT style, base64-heavy)
        '/aws_session_token\s*=\s*([A-Za-z0-9\/+=]{100,})/i',

        // AWS S3 Bucket & Endpoint
        '/s3:\/\/[0-9a-zA-Z._\/-]+/',                              // s3:// style URI
        '/https:\/\/[a-z0-9.-]+\.s3\.amazonaws\.com/',             // HTTPS style bucket
        '/[a-z0-9.-]+\.s3\.[a-z0-9-]+\.amazonaws\.com/',           // Regional S3 endpoint

        // AWS RDS
        '/[a-z0-9.-]+\.rds\.amazonaws\.com/',

        // AWS API Gateway
        '/[a-z0-9]+\.execute-api\.[a-z0-9-]+\.amazonaws\.com/',

        // AWS AppSync
        '/da2-[a-z0-9]{26}/',

        // AWS CloudFront
        '/https:\/\/[a-z0-9]+\.cloudfront\.net/',

        // AWS ELB
        '/[a-z0-9.-]+\.elb\.amazonaws\.com/',

        // AWS Cognito
        '/us-[a-z0-9]+-\d+_[a-zA-Z0-9]+/',                         // Cognito User Pool ID
        '/[a-z0-9]{20,30}/',                                       // Cognito Client ID (generic)

        // AWS Region
        '/us-(east|west|central)-[0-9]/i',                         // Region format

        // AWS Profile
        '/aws_profile\s*=\s*[a-zA-Z0-9_-]+/',
        '/\bmanjeet\b/i',

    ],
];
