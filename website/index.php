<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riely Valorant Clips</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <style>
        .container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .glitch-wrapper {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            flex-direction: column; /* Center content vertically */
        }

        .glitch {
            position: relative;
            font-size: 80px;
            font-weight: 700;
            line-height: 1.2;
            color: #000000;
            letter-spacing: 5px;
            z-index: 1;
        }

        .glitch:before,
        .glitch:after {
            display: block;
            content: attr(data-glitch);
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0.8;
        }

        .glitch:before {
            animation: glitch-color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) both infinite;
            color: #ff6d6d;
            z-index: -1;
        }

        .glitch:after {
            animation: glitch-color 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94) reverse both infinite;
            color: #ffffff;
            z-index: -2;
        }

        /* Custom CSS to change button text color */
        .btn.btn-warning {
            color: #ffffff;
            z-index: 1;
  position: relative;
  font-size: inherit;
  font-family: inherit;
  color: white;
  padding: 0.5em 1em;
  outline: none;
  border: none;
  background-color:#53212b;
  overflow: hidden;
  transition: color 0.4s ease-in-out;
        }
    .btn.btn-warning::before {
  content: '';
  z-index: -1;
  position: absolute;
  top: 50%;
  left: 50%;
  width: 1em;
  height: 1em;
  border-radius: 50%;
  background-color: #fff;
  transform-origin: center;
  transform: translate3d(-50%, -50%, 0) scale3d(0, 0, 0);
  transition: transform 0.45s ease-in-out;
}

.btn.btn-warning:hover {
  cursor: pointer;
  color: #161616;
}

.btn.btn-warning:hover::before {
  transform: translate3d(-50%, -50%, 0) scale3d(15, 15, 15);
}

        @keyframes glitch-color {
            0% {
                transform: translate(0);
            }

            20% {
                transform: translate(-3px, 3px);
            }

            40% {
                transform: translate(-3px, -3px);
            }

            60% {
                transform: translate(3px, 3px);
            }

            80% {
                transform: translate(3px, -3px);
            }

            to {
                transform: translate(0);
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="glitch-wrapper">
            <div class="glitch" data-glitch="Riely Valorant Clips">Riely Valorant Clips</div>
            <div>
                <a href="login.php" class="btn btn-warning">Login</a>
                <a href="registration.php" class="btn btn-warning">Register</a>
            </div>
        </div>
    </div>
</body>
</html>
