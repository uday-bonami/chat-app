const ws = new WebSocket("ws://192.168.101.72:8080");
const webCam = document.getElementById("my-video");
const userCam = document.getElementById("connection-video");
const servers = {
  iceServers: [
    {
      urls: ["stun:stun1.l.google.com:19302", "stun:stun2.l.google.com:19302"],
    },
  ],
  iceCandidatePoolSize: 10,
};
const peer = new RTCPeerConnection(servers);

function startSocketConnection() {
  ws.onopen = (e) => {
    // ...
  };

  ws.onmessage = (e) => {
    const message = JSON.parse(e.data);
    if (message["type"] == "join_call") {
      // ...
    } else if (message["type"] == "end_call") {
      // ...
    }
  };

  ws.onclose = (e) => {
    // ...
  };
}

function startMedia(audio = true, video = true) {
  let constrains = {
    audio: audio,
    video: video,
  };
  navigator.mediaDevices.getUserMedia(constrains).then((stream) => {
    webCam.srcObject = stream;
  });
}

function main() {
  startSocketConnection();
  startMedia();
}

main();
