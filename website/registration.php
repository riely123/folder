<?php
    session_start();
    if (isset($_SESSION["user"])){
        header("Location: index.php");
    }

    if(isset($_POST["submit"])) {
        $lastName = $_POST["LastName"];
        $firstName = $_POST["FirstName"];
        $address = $_POST["address"];
        $country = $_POST["country"];
        $contact = $_POST["contact"];
        $email = $_POST["Email"];
        $password = $_POST["password"];
        $repeatPassword = $_POST["repeat_password"];
       
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $errors = array();
        if (empty($lastName) || empty($firstName) || empty($email) || empty($password) || empty($repeatPassword)) {
            array_push($errors, "All fields are required");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            array_push($errors, "Email is not valid");
        }

        if(strlen($password) < 8) {
            array_push($errors, "Password must be at least 8 characters long");
        }

        if($password != $repeatPassword){
            array_push($errors, "Password does not match");
        }

        require_once "database.php";
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $rowCount = mysqli_num_rows($result);
        if($rowCount > 0){
            array_push($errors,"Email Already Exists.");
        }

        if (count($errors) > 0){
            foreach($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            $sql = "INSERT INTO user (last_name, first_name, email, password, country, contact) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "ssssss", $lastName, $firstName, $email, $passwordHash, $country, $contact);
            mysqli_stmt_execute($stmt);
            echo "<div class='alert alert-success'>You are Registered Successfully!</div>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <form action="registration.php" method="post">
    <div class="form-group">
    <input type="text" class="form-control" name="LastName" placeholder="Last Name">
</div>
<div class="form-group">
    <input type="text" class="form-control" name="FirstName" placeholder="First Name">
</div>
<div class="form-group">
    <input type="text" class="form-control" name="address" placeholder="Address">
</div>

<!-- Include country dropdown -->
<div class="form-group">
    <label for="country">Country:</label>
    <select class="form-control" id="country" name="country" onchange="updateContactCode()">
        <?php
        // Array of all countries with their country codes
        $countries = [
                    'AF' => 'Afghanistan',
                    'AL' => 'Albania',
                    'DZ' => 'Algeria',
                    'AS' => 'American Samoa',
                    'AD' => 'Andorra',
                    'AO' => 'Angola',
                    'AI' => 'Anguilla',
                    'AQ' => 'Antarctica',
                    'AG' => 'Antigua and Barbuda',
                    'AR' => 'Argentina',
                    'AM' => 'Armenia',
                    'AW' => 'Aruba',
                    'AU' => 'Australia',
                    'AT' => 'Austria',
                    'AZ' => 'Azerbaijan',
                    'BS' => 'Bahamas',
                    'BH' => 'Bahrain',
                    'BD' => 'Bangladesh',
                    'BB' => 'Barbados',
                    'BY' => 'Belarus',
                    'BE' => 'Belgium',
                    'BZ' => 'Belize',
                    'BJ' => 'Benin',
                    'BM' => 'Bermuda',
                    'BT' => 'Bhutan',
                    'BO' => 'Bolivia',
                    'BA' => 'Bosnia and Herzegovina',
                    'BW' => 'Botswana',
                    'BV' => 'Bouvet Island',
                    'BR' => 'Brazil',
                    'IO' => 'British Indian Ocean Territory',
                    'BN' => 'Brunei Darussalam',
                    'BG' => 'Bulgaria',
                    'BF' => 'Burkina Faso',
                    'BI' => 'Burundi',
                    'KH' => 'Cambodia',
                    'CM' => 'Cameroon',
                    'CA' => 'Canada',
                    'CV' => 'Cape Verde',
                    'KY' => 'Cayman Islands',
                    'CF' => 'Central African Republic',
                    'TD' => 'Chad',
                    'CL' => 'Chile',
                    'CN' => 'China',
                    'CX' => 'Christmas Island',
                    'CC' => 'Cocos (Keeling) Islands',
                    'CO' => 'Colombia',
                    'KM' => 'Comoros',
                    'CG' => 'Congo',
                    'CD' => 'Congo, the Democratic Republic of the',
                    'CK' => 'Cook Islands',
                    'CR' => 'Costa Rica',
                    'CI' => 'Cote d\'Ivoire',
                    'HR' => 'Croatia',
                    'CU' => 'Cuba',
                    'CY' => 'Cyprus',
                    'CZ' => 'Czech Republic',
                    'DK' => 'Denmark',
                    'DJ' => 'Djibouti',
                    'DM' => 'Dominica',
                    'DO' => 'Dominican Republic',
                    'EC' => 'Ecuador',
                    'EG' => 'Egypt',
                    'SV' => 'El Salvador',
                    'GQ' => 'Equatorial Guinea',
                    'ER' => 'Eritrea',
                    'EE' => 'Estonia',
                    'ET' => 'Ethiopia',
                    'FK' => 'Falkland Islands (Malvinas)',
                    'FO' => 'Faroe Islands',
                    'FJ' => 'Fiji',
                    'FI' => 'Finland',
                    'FR' => 'France',
                    'GF' => 'French Guiana',
                    'PF' => 'French Polynesia',
                    'TF' => 'French Southern Territories',
                    'GA' => 'Gabon',
                    'GM' => 'Gambia',
                    'GE' => 'Georgia',
                    'DE' => 'Germany',
                    'GH' => 'Ghana',
                    'GI' => 'Gibraltar',
                    'GR' => 'Greece',
                    'GL' => 'Greenland',
                    'GD' => 'Grenada',
                    'GP' => 'Guadeloupe',
                    'GU' => 'Guam',
                    'GT' => 'Guatemala',
                    'GN' => 'Guinea',
                    'GW' => 'Guinea-Bissau',
                    'GY' => 'Guyana',
                    'HT' => 'Haiti',
                    'HM' => 'Heard Island and McDonald Islands',
                    'VA' => 'Holy See (Vatican City State)',
                    'HN' => 'Honduras',
                    'HK' => 'Hong Kong',
                    'HU' => 'Hungary',
                    'IS' => 'Iceland',
                    'IN' => 'India',
                    'ID' => 'Indonesia',
                    'IR' => 'Iran, Islamic Republic of',
                    'IQ' => 'Iraq',
                    'IE' => 'Ireland',
                    'IL' => 'Israel',
                    'IT' => 'Italy',
                    'JM' => 'Jamaica',
                    'JP' => 'Japan',
                    'JO' => 'Jordan',
                    'KZ' => 'Kazakhstan',
                    'KE' => 'Kenya',
                    'KI' => 'Kiribati',
                    'KP' => 'Korea, Democratic People\'s Republic of',
                    'KR' => 'Korea, Republic of',
                    'KW' => 'Kuwait',
                    'KG' => 'Kyrgyzstan',
                    'LA' => 'Lao People\'s Democratic Republic',
                    'LV' => 'Latvia',
                    'LB' => 'Lebanon',
                    'LS' => 'Lesotho',
                    'LR' => 'Liberia',
                    'LY' => 'Libyan Arab Jamahiriya',
                    'LI' => 'Liechtenstein',
                    'LT' => 'Lithuania',
                    'LU' => 'Luxembourg',
                    'MO' => 'Macao',
                    'MK' => 'Macedonia, the former Yugoslav Republic of',
                    'MG' => 'Madagascar',
                    'MW' => 'Malawi',
                    'MY' => 'Malaysia',
                    'MV' => 'Maldives',
                    'ML' => 'Mali',
                    'MT' => 'Malta',
                    'MH' => 'Marshall Islands',
                    'MQ' => 'Martinique',
                    'MR' => 'Mauritania',
                    'MU' => 'Mauritius',
                    'YT' => 'Mayotte',
                    'MX' => 'Mexico',
                    'FM' => 'Micronesia, Federated States of',
                    'MD' => 'Moldova, Republic of',
                    'MC' => 'Monaco',
                    'MN' => 'Mongolia',
                    'MS' => 'Montserrat',
                    'MA' => 'Morocco',
                    'MZ' => 'Mozambique',
                    'MM' => 'Myanmar',
                    'NA' => 'Namibia',
                    'NR' => 'Nauru',
                    'NP' => 'Nepal',
                    'NL' => 'Netherlands',
                    'AN' => 'Netherlands Antilles',
                    'NC' => 'New Caledonia',
                    'NZ' => 'New Zealand',
                    'NI' => 'Nicaragua',
                    'NE' => 'Niger',
                    'NG' => 'Nigeria',
                    'NU' => 'Niue',
                    'NF' => 'Norfolk Island',
                    'MP' => 'Northern Mariana Islands',
                    'NO' => 'Norway',
                    'OM' => 'Oman',
                    'PK' => 'Pakistan',
                    'PW' => 'Palau',
                    'PS' => 'Palestinian Territory, Occupied',
                    'PA' => 'Panama',
                    'PG' => 'Papua New Guinea',
                    'PY' => 'Paraguay',
                    'PE' => 'Peru',
                    'PH' => 'Philippines',
                    'PN' => 'Pitcairn',
                    'PL' => 'Poland',
                    'PT' => 'Portugal',
                    'PR' => 'Puerto Rico',
                    'QA' => 'Qatar',
                    'RE' => 'Reunion',
                    'RO' => 'Romania',
                    'RU' => 'Russian Federation',
                    'RW' => 'Rwanda',
                    'SH' => 'Saint Helena',
                    'KN' => 'Saint Kitts and Nevis',
                    'LC' => 'Saint Lucia',
                    'PM' => 'Saint Pierre and Miquelon',
                    'VC' => 'Saint Vincent and the Grenadines',
                    'WS' => 'Samoa',
                    'SM' => 'San Marino',
                    'ST' => 'Sao Tome and Principe',
                    'SA' => 'Saudi Arabia',
                    'SN' => 'Senegal',
                    'CS' => 'Serbia and Montenegro',
                    'SC' => 'Seychelles',
                    'SL' => 'Sierra Leone',
                    'SG' => 'Singapore',
                    'SK' => 'Slovakia',
                    'SI' => 'Slovenia',
                    'SB' => 'Solomon Islands',
                    'SO' => 'Somalia',
                    'ZA' => 'South Africa',
                    'GS' => 'South Georgia and the South Sandwich Islands',
                    'ES' => 'Spain',
                    'LK' => 'Sri Lanka',
                    'SD' => 'Sudan',
                    'SR' => 'Suriname',
                    'SJ' => 'Svalbard and Jan Mayen',
                    'SZ' => 'Swaziland',
                    'SE' => 'Sweden',
                    'CH' => 'Switzerland',
                    'SY' => 'Syrian Arab Republic',
                    'TW' => 'Taiwan, Province of China',
                    'TJ' => 'Tajikistan',
                    'TZ' => 'Tanzania, United Republic of',
                    'TH' => 'Thailand',
                    'TL' => 'Timor-Leste',
                    'TG' => 'Togo',
                    'TK' => 'Tokelau',
                    'TO' => 'Tonga',
                    'TT' => 'Trinidad and Tobago',
                    'TN' => 'Tunisia',
                    'TR' => 'Turkey',
                    'TM' => 'Turkmenistan',
                    'TC' => 'Turks and Caicos Islands',
                    'TV' => 'Tuvalu',
                    'UG' => 'Uganda',
                    'UA' => 'Ukraine',
                    'AE' => 'United Arab Emirates',
                    'GB' => 'United Kingdom',
                    'US' => 'United States',
                    'UM' => 'United States Minor Outlying Islands',
                    'UY' => 'Uruguay',
                    'UZ' => 'Uzbekistan',
                    'VU' => 'Vanuatu',
                    'VE' => 'Venezuela',
                    'VN' => 'Viet Nam',
                    'VG' => 'Virgin Islands, British',
                    'VI' => 'Virgin Islands, U.S.',
                    'WF' => 'Wallis and Futuna',
                    'EH' => 'Western Sahara',
                    'YE' => 'Yemen',
                    'ZM' => 'Zambia',
                    'ZW' => 'Zimbabwe',
        ];

        // Loop through the countries array to generate options
        foreach ($countries as $code => $country) {
            echo "<option value='$code'>$country</option>";
        }
        ?>
    </select>
</div>
<!-- End country dropdown -->
<div class="form-group">
    <!-- Include contact input field -->
    <input type="text" class="form-control" id="contact" name="contact" placeholder="Contact">
</div>
<div class="form-group">
    <input type="email" class="form-control" name="Email" placeholder="Email">
</div>
<div class="form-group">
    <input type="password" class="form-control" name="password" placeholder="Password">
</div>
<div class="form-group">
    <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
</div>
<div class="form-group">
    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    <div> <p> Already registered? <a href="login.php"> Login here </a> </div>
</div>
    </form>
</div>


<script>
    // Function to update the contact code based on the selected country
    function updateContactCode() {
        var countrySelect = document.getElementById("country");
        var contactField = document.getElementById("contact");
        var selectedCountry = countrySelect.value;

        // Object containing country codes for selected countries
        var countryCodes = {
    'AF': '+93', // Afghanistan
    'AL': '+355', // Albania
    'DZ': '+213', // Algeria
    'AS': '+1-684', // American Samoa
    'AD': '+376', // Andorra
    'AO': '+244', // Angola
    'AI': '+1-264', // Anguilla
    'AQ': '', // Antarctica - no country code
    'AG': '+1-268', // Antigua and Barbuda
    'AR': '+54', // Argentina
    'AM': '+374', // Armenia
    'AW': '+297', // Aruba
    'AU': '+61', // Australia
    'AT': '+43', // Austria
    'AZ': '+994', // Azerbaijan
    'BS': '+1-242', // Bahamas
    'BH': '+973', // Bahrain
    'BD': '+880', // Bangladesh
    'BB': '+1-246', // Barbados
    'BY': '+375', // Belarus
    'BE': '+32', // Belgium
    'BZ': '+501', // Belize
    'BJ': '+229', // Benin
    'BM': '+1-441', // Bermuda
    'BT': '+975', // Bhutan
    'BO': '+591', // Bolivia
    'BA': '+387', // Bosnia and Herzegovina
    'BW': '+267', // Botswana
    'BV': '', // Bouvet Island - no country code
    'BR': '+55', // Brazil
    'IO': '+246', // British Indian Ocean Territory
    'BN': '+673', // Brunei Darussalam
    'BG': '+359', // Bulgaria
    'BF': '+226', // Burkina Faso
    'BI': '+257', // Burundi
    'KH': '+855', // Cambodia
    'CM': '+237', // Cameroon
    'CA': '+1', // Canada
    'CV': '+238', // Cape Verde
    'KY': '+1-345', // Cayman Islands
    'CF': '+236', // Central African Republic
    'TD': '+235', // Chad
    'CL': '+56', // Chile
    'CN': '+86', // China
    'CX': '+61', // Christmas Island
    'CC': '+61', // Cocos (Keeling) Islands
    'CO': '+57', // Colombia
    'KM': '+269', // Comoros
    'CG': '+242', // Congo
    'CD': '+243', // Congo, the Democratic Republic of the
    'CK': '+682', // Cook Islands
    'CR': '+506', // Costa Rica
    'CI': '+225', // Cote d'Ivoire
    'HR': '+385', // Croatia
    'CU': '+53', // Cuba
    'CY': '+357', // Cyprus
    'CZ': '+420', // Czech Republic
    'DK': '+45', // Denmark
    'DJ': '+253', // Djibouti
    'DM': '+1-767', // Dominica
    'DO': '+1-809, 1-829, 1-849', // Dominican Republic
    'EC': '+593', // Ecuador
    'EG': '+20', // Egypt
    'SV': '+503', // El Salvador
    'GQ': '+240', // Equatorial Guinea
    'ER': '+291', // Eritrea
    'EE': '+372', // Estonia
    'ET': '+251', // Ethiopia
    'FK': '+500', // Falkland Islands (Malvinas)
    'FO': '+298', // Faroe Islands
    'FJ': '+679', // Fiji
    'FI': '+358', // Finland
    'FR': '+33', // France
    'GF': '+594', // French Guiana
    'PF': '+689', // French Polynesia
    'TF': '', // French Southern Territories - no country code
    'GA': '+241', // Gabon
    'GM': '+220', // Gambia
    'GE': '+995', // Georgia
    'DE': '+49', // Germany
    'GH': '+233', // Ghana
    'GI': '+350', // Gibraltar
    'GR': '+30', // Greece
    'GL': '+299', // Greenland
    'GD': '+1-473', // Grenada
    'GP': '+590', // Guadeloupe
    'GU': '+1-671', // Guam
    'GT': '+502', // Guatemala
    'GN': '+224', // Guinea
    'GW': '+245', // Guinea-Bissau
    'GY': '+592', // Guyana
    'HT': '+509', // Haiti
    'HM': '', // Heard Island and McDonald Islands - no country code
    'VA': '+379', // Holy See (Vatican City State)
    'HN': '+504', // Honduras
    'HK': '+852', // Hong Kong
    'HU': '+36', // Hungary
    'IS': '+354', // Iceland
    'IN': '+91', // India
    'ID': '+62', // Indonesia
    'IR': '+98', // Iran, Islamic Republic of
    'IQ': '+964', // Iraq
    'IE': '+353', // Ireland
    'IL': '+972', // Israel
    'IT': '+39', // Italy
    'JM': '+1-876', // Jamaica
    'JP': '+81', // Japan
    'JO': '+962', // Jordan
    'KZ': '+7', // Kazakhstan
    'KE': '+254', // Kenya
    'KI': '+686', // Kiribati
    'KP': '+850', // Korea, Democratic People's Republic of
    'KR': '+82', // Korea, Republic of
    'KW': '+965', // Kuwait
    'KG': '+996', // Kyrgyzstan
    'LA': '+856', // Lao People's Democratic Republic
    'LV': '+371', // Latvia
    'LB': '+961', // Lebanon
    'LS': '+266', // Lesotho
    'LR': '+231', // Liberia
    'LY': '+218', // Libyan Arab Jamahiriya
    'LI': '+423', // Liechtenstein
    'LT': '+370', // Lithuania
    'LU': '+352', // Luxembourg
    'MO': '+853', // Macao
    'MK': '+389', // Macedonia, the former Yugoslav Republic of
    'MG': '+261', // Madagascar
    'MW': '+265', // Malawi
    'MY': '+60', // Malaysia
    'MV': '+960', // Maldives
    'ML': '+223', // Mali
    'MT': '+356', // Malta
    'MH': '+692', // Marshall Islands
    'MQ': '+596', // Martinique
    'MR': '+222', // Mauritania
    'MU': '+230', // Mauritius
    'YT': '+262', // Mayotte
    'MX': '+52', // Mexico
    'FM': '+691', // Micronesia, Federated States of
    'MD': '+373', // Moldova, Republic of
    'MC': '+377', // Monaco
    'MN': '+976', // Mongolia
    'MS': '+1-664', // Montserrat
    'MA': '+212', // Morocco
    'MZ': '+258', // Mozambique
    'MM': '+95', // Myanmar
    'NA': '+264', // Namibia
    'NR': '+674', // Nauru
    'NP': '+977', // Nepal
    'NL': '+31', // Netherlands
    'AN': '+599', // Netherlands Antilles
    'NC': '+687', // New Caledonia
    'NZ': '+64', // New Zealand
    'NI': '+505', // Nicaragua
    'NE': '+227', // Niger
    'NG': '+234', // Nigeria
    'NU': '+683', // Niue
    'NF': '+672', // Norfolk Island
    'MP': '+1-670', // Northern Mariana Islands
    'NO': '+47', // Norway
    'OM': '+968', // Oman
    'PK': '+92', // Pakistan
    'PW': '+680', // Palau
    'PS': '+970', // Palestinian Territory, Occupied
    'PA': '+507', // Panama
    'PG': '+675', // Papua New Guinea
    'PY': '+595', // Paraguay
    'PE': '+51', // Peru
    'PH': '+63', // Philippines
    'PN': '+64', // Pitcairn
    'PL': '+48', // Poland
    'PT': '+351', // Portugal
    'PR': '+1-787', // Puerto Rico
    'QA': '+974', // Qatar
    'RE': '+262', // Reunion
    'RO': '+40', // Romania
    'RU': '+7', // Russian Federation
    'RW': '+250', // Rwanda
    'SH': '+290', // Saint Helena
    'KN': '+1-869', // Saint Kitts and Nevis
    'LC': '+1-758', // Saint Lucia
    'PM': '+508', // Saint Pierre and Miquelon
    'VC': '+1-784', // Saint Vincent and the Grenadines
    'WS': '+685', // Samoa
    'SM': '+378', // San Marino
    'ST': '+239', // Sao Tome and Principe
    'SA': '+966', // Saudi Arabia
    'SN': '+221', // Senegal
    'CS': '+381', // Serbia and Montenegro
    'SC': '+248', // Seychelles
    'SL': '+232', // Sierra Leone
    'SG': '+65', // Singapore
    'SK': '+421', // Slovakia
    'SI': '+386', // Slovenia
    'SB': '+677', // Solomon Islands
    'SO': '+252', // Somalia
    'ZA': '+27', // South Africa
    'GS': '', // South Georgia and the South Sandwich Islands - no country code
    'ES': '+34', // Spain
    'LK': '+94', // Sri Lanka
    'SD': '+249', // Sudan
    'SR': '+597', // Suriname
    'SJ': '+47', // Svalbard and Jan Mayen
    'SZ': '+268', // Swaziland
    'SE': '+46', // Sweden
    'CH': '+41', // Switzerland
    'SY': '+963', // Syrian Arab Republic
    'TW': '+886', // Taiwan, Province of China
    'TJ': '+992', // Tajikistan
    'TZ': '+255', // Tanzania, United Republic of
    'TH': '+66', // Thailand
    'TL': '+670', // Timor-Leste
    'TG': '+228', // Togo
    'TK': '+690', // Tokelau
    'TO': '+676', // Tonga
    'TT': '+1-868', // Trinidad and Tobago
    'TN': '+216', // Tunisia
    'TR': '+90', // Turkey
    'TM': '+993', // Turkmenistan
    'TC': '+1-649', // Turks and Caicos Islands
    'TV': '+688', // Tuvalu
    'UG': '+256', // Uganda
    'UA': '+380', // Ukraine
    'AE': '+971', // United Arab Emirates
    'GB': '+44', // United Kingdom
    'US': '+1', // United States
    'UM': '', // United States Minor Outlying Islands - no country code
    'UY': '+598', // Uruguay
    'UZ': '+998', // Uzbekistan
    'VU': '+678', // Vanuatu
    'VE': '+58', // Venezuela
    'VN': '+84', // Vietnam
    'VG': '+1-284', // Virgin Islands, British
    'VI': '+1-340', // Virgin Islands, U.S.
    'WF': '+681', // Wallis and Futuna
    'EH': '+212', // Western Sahara
    'YE': '+967', // Yemen
    'ZM': '+260', // Zambia
    'ZW': '+263' // Zimbabwe
};

        // Update the contact field with the corresponding country code
        if (selectedCountry in countryCodes) {
            contactField.value = countryCodes[selectedCountry];
        }
    }
</script>
</body>
</html>
