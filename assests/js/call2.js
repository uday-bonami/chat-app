const ws = new WebSocket("ws://localhost:8080");
const webCam = document.getElementById("my-video");
const userCam = document.getElementById("connection-video");
const peer = new Peer({
  iceServers: [
    {
      urls: "stun:stun.stunprotocol.org",
    },
    {
      urls: "turn:numb.viagenie.ca",
      credential: "muazkh",
      username: "webrtc@live.com",
    },
  ],
});

const streams = [];
let userToken;

function getMedia() {
  const constrains = {
    audio: true,
    video: true,
  };
  navigator.mediaDevices.getUserMedia(constrains).then((stream) => {
    webCam.srcObject = stream;
    webCam.muted = true;
    streams.push(stream);
    peer.on("call", (joinCall) => {
      joinCall.answer(stream);
      joinCall.on("stream", (userVideoStrem) => {
        userCam.srcObject = userVideoStrem;
      });
    });
  });
}

function startPeerConnection() {
  getMedia();
  peer.on("open", (id) => {
    const connectionData = {
      userId: id,
      type: "start-call",
      target: target,
    };
    ws.send(JSON.stringify(connectionData));
  });
}

function checkConfirmation(message) {
  if (message["confirmation"]) {
    startPeerConnection();
  } else {
    ws.close();
    window.location.replace("./chat.php");
  }
}

ws.onopen = () => {
  console.log("Connection done");
  const connectionData = JSON.stringify({
    userId: userId,
    type: "connect",
  });
  ws.send(connectionData);
  const connectionMsg = {
    type: "join-call",
    userId: userId,
    target: target,
  };
  ws.send(JSON.stringify(connectionMsg));
};

ws.onmessage = (e) => {
  const message = JSON.parse(e.data);
  if (message["type"]) {
    if (message["type"] == "join-call") {
      checkConfirmation(message);
    } else if (message["type"] == "start-call") {
      console.log(message);
      // userToken = message["userId"];
      const peercall = peer.call(message["userId"], streams[0]);
      //   console.log(peer);
      peercall.on("stream", (userStream) => {
        console.log(userStream);
        userCam.srcObject = userStream;
      });
      peercall.on("close", () => {
        userCam.remove();
      });
    }
  }
};
