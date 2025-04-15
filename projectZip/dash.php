<!-- index.php -->

<?php
session_start();
if (!isset($_SESSION['username'])) {
    echo "<script>
        alert('Please login first!');
        window.location.href = 'index.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/128/972/972623.png" type="image/png">
  <title>AKN Creations | Dashboard</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", sans-serif;
    }

    body {
      background: linear-gradient(to right, #0f2027, #2c5364, #0f2027);
      color:whitesmoke;
      min-height: 100vh;
      padding: 20px;
    }

    header {
      text-align: center;
      margin-bottom: 30px;
    }

    .mic-btn {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      border:none;
      background: cornflowerblue;
      color: #fff;
      font-size: 24px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 10px auto;
      cursor: pointer;
      box-shadow: 0 0 10px rgba(0,0,0,0.5);
      position: relative;
      transition: 0.3s;
    }

    .mic-btn:hover {
      background-color: crimson;
    }

    /* Circle effect on mic button */
    .mic-btn.active {
      animation: micActive 0.8s infinite;
    }

    @keyframes micActive {
      0% {
        transform: scale(1);
        box-shadow: 0 0 0 rgba(0, 255, 0, 0.5);
      }
      50% {
        transform: scale(1.2);
        box-shadow: 0 0 15px rgba(0, 255, 0, 0.8);
      }
      100% {
        transform: scale(1);
        box-shadow: 0 0 0 rgba(0, 255, 0, 0.5);
      }
    }

    .relay-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 20px;
      margin-bottom: 40px;
    }

    .relay {
      background: #1e1e1e;
      padding: 20px;
      border-radius: 12px;
      text-align: center;
      position: relative;
      box-shadow: 0 0 15px rgba(0,0,0,0.3);
    }

    .relay h3 {
      margin-bottom: 10px;
    }

    .status-dot {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      display: inline-block;
      margin-left: 10px;
      vertical-align: middle;
    }

    .dot-on {
      background: #00ff00;
      animation: blink 1s infinite;
    }

    .dot-off {
      background: red;
    }

    @keyframes blink {
      50% { opacity: 0.3; }
    }

    .relay button {
      padding: 10px 20px;
      margin: 5px;
      border: none;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
      transition: 0.3s;
    }

    .on-btn {
      background: #00c853;
      color: #fff;
    }

    .off-btn {
      background: #d32f2f;
      color: #fff;
    }

    .on-btn:hover {
      background: #00e676;
    }

    .off-btn:hover {
      background: #e53935;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #1c1c1c;
      border-radius: 12px;
      overflow: hidden;
    }

    th, td {
      padding: 15px;
      text-align: center;
      border-bottom: 1px solid #333;
    }

    th {
      background: #111;
      color:#dc143c;
      font-weight: 500;
    }

    @media (max-width: 600px) {
      .relay-grid {
        grid-template-columns: 1fr;
      }
    }

    footer {
      text-align: center;
      margin-top: 30px;
      font-size: 14px;
      color: #ccc;
    }
  </style>
</head>
<body>

  <header>
    <h1>Smart Device Control Dashboard</h1>
    <br>
    <hr>
    <br>
    <button class="mic-btn" id="micBtn"><i class="fas fa-microphone"></i></button>
  </header>

  <section class="relay-grid">
    <!-- Update to show 4 relays -->
    <?php for ($i = 1; $i <= 4; $i++): ?>
      <div class="relay">
        <h3>Device<?php echo $i; ?>
          <span id="status<?php echo $i; ?>" class="status-dot dot-off"></span>
        </h3>
        <button class="on-btn" onclick="controlRelay(<?php echo $i; ?>, 'ON')">ON</button>
        <button class="off-btn" onclick="controlRelay(<?php echo $i; ?>, 'OFF')">OFF</button>
      </div>
    <?php endfor; ?>
  </section>

  <section>
    <h2>Device Activity Log</h2>
    <br>
    <table id="status-table">
      <thead>
        <tr>
          <th>Device</th>
          <th>Status</th>
          <th>Timestamp</th>
        </tr>
      </thead>
      <tbody>
        <tr><td colspan="3">Loading...</td></tr>
      </tbody>
    </table>
  </section>
  <audio id="okAudio" src="ttsMP3.com_VoiceText_2025-4-10_19-49-44.mp3"></audio>

  <script>
        // Function to control relay (ON or OFF)
        function controlRelay(relay, state) {
            fetch(`api.php?relay=${relay}&state=${state}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    updateRelayStatus(relay, state);  // Update dot color based on relay state
                });
        }

        // Function to update the relay status and change the dot color
        function updateRelayStatus(relay, state) {
            let statusDot = document.getElementById(`status${relay}`);
            
            if (state === "ON") {
                statusDot.classList.remove("dot-off");
                statusDot.classList.add("dot-on");
            } else {
                statusDot.classList.remove("dot-on");
                statusDot.classList.add("dot-off");
            }
        }

        // Function to update the status table
        function updateStatus() {
            fetch('fetchStatus.php')
                .then(response => response.json())
                .then(data => {
                    let tableBody = document.getElementById('status-table');
                    tableBody.innerHTML = "";

                    data.forEach(row => {
                        let newRow = `<tr>
                                        <td>${row.device_name}</td>
                                        <td>${row.status}</td>
                                        <td>${row.updated_at}</td>
                                      </tr>`;
                        tableBody.innerHTML += newRow;
                    });
                });
        }

        setInterval(updateStatus, 3000);
        updateStatus();

        // Speech Recognition Setup
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.continuous = false;
        recognition.lang = "en-US";
        recognition.interimResults = false;

        // Play audio when command is executed
        function playOkAudio() {
            const audio = document.getElementById("okAudio");
            audio.currentTime = 0;
            audio.play();
        }

        function startListening() {
    const micBtn = document.getElementById("micBtn");
    micBtn.classList.add("active");
    recognition.start();
}

// Jab voice input complete ho jaye, tab effect hata do
recognition.onend = function () {
    const micBtn = document.getElementById("micBtn");
    micBtn.classList.remove("active");
};

        recognition.onresult = function(event) {
            let command = event.results[0][0].transcript.toLowerCase();
            console.log("You said:", command);

            if (command.includes("kitchen light on")) {
                controlRelay(1, "ON");
                playOkAudio();
            } else if (command.includes("kitchen light off")) {
                controlRelay(1, "OFF");
                playOkAudio();
            } else if (command.includes("room light on")) {
                controlRelay(2, "ON");
                playOkAudio();
            } else if (command.includes("room light off")) {
                controlRelay(2, "OFF");
                playOkAudio();
            } else if (command.includes("balcony light on")) {
                controlRelay(3, "ON");
                playOkAudio();
            } else if (command.includes("balcony light off")) {
                controlRelay(3, "OFF");
                playOkAudio();
            } else if (command.includes("hall light on")) {
                controlRelay(4, "ON");
                playOkAudio();
            } else if (command.includes("hall light off")) {
                controlRelay(4, "OFF");
                playOkAudio();
            } else {
                alert("Sorry, I didn’t understand the command.");
            }
        };

        recognition.onerror = function(event) {
            console.error("Recognition error:", event.error);
        };

        // Mic button click
        document.getElementById("micBtn").onclick = startListening;
    
  </script>

</body>
</html>
