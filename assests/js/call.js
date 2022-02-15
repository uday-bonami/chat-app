const ws = new WebSocket("ws://localhost:8080");
const webCam = document.getElementById("my-video");
const userCam = document.getElementById("connection-video");
const streams = [];
const servers = {
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
};
const peer = new RTCPeerConnection(servers);

function handleNegotiationNeededEvent() {
  peer
    .createOffer()
    .then((offer) => {
      // console.log(offer);
      return peer.setLocalDescription(offer);
    })
    .then(() => {
      console.log(peer.localDescription);
      const payload = {
        target: target,
        caller: userId,
        sdp: peer.localDescription,
        type: "offer",
      };
      ws.send(JSON.stringify(payload));
    })
    .catch((e) => console.log(e));
}

function handleTrackEvent(e) {
  userCam.srcObject = e.streams[0];
}

function handleICECandidateEvent(e) {
  if (e.candidate) {
    const payload = {
      target: target,
      candidate: e.candidate,
      type: "ice-candidate",
    };
    ws.send(JSON.stringify(payload));
  }
}

function createPeer() {
  const newpeer = new RTCPeerConnection(servers);
  newpeer.onicecandidate = handleICECandidateEvent;
  newpeer.ontrack = handleTrackEvent;
  newpeer.onnegotiationneeded = () => handleNegotiationNeededEvent();
  return newpeer;
}

function startPeer() {
  peer.onicecandidate = handleICECandidateEvent;
  peer.ontrack = handleTrackEvent;
  peer.onnegotiationneeded = () => handleNegotiationNeededEvent();
}

function handleNewICECandidateMsg(incoming) {
  const iceCandidateData = incoming.candidate;
  if (iceCandidateData.candidate) {
    const candidate = new RTCIceCandidate(iceCandidateData);
    console.log(candidate);
    peer.addIceCandidate(candidate).catch((e) => console.log(e));
  }
}

function startPeerConnection() {
  let constrains = {
    audio: true,
    video: true,
  };
  navigator.mediaDevices.getUserMedia(constrains).then((stream) => {
    webCam.srcObject = stream;
    startPeer();
    streams.push(stream);
    stream.getTracks().forEach((track) => {
      peer.addTrack(track, stream);
    });
  });
}

function handleRecieveCall(incoming) {
  let peerRef = createPeer();
  const desc = new RTCSessionDescription(incoming.sdp);
  peerRef
    .setRemoteDescription(desc)
    .then(() => {
      streams[0]
        .getTracks()
        .forEach((track) => peerRef.addTrack(track, streams[0]));
    })
    .then(() => {
      return peerRef.createAnswer();
    })
    .then((answer) => {
      return peerRef.setLocalDescription(answer);
    })
    .then(() => {
      const payload = {
        target: incoming.caller,
        caller: userId,
        sdp: peerRef.localDescription,
        type: "answer",
      };
      ws.send(JSON.stringify(payload));
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

function startSocketConnection() {
  // const connectionMsg = {
  //   type: "join-call",
  //   userId: userId,
  //   target: target,
  // };
  // ws.send(JSON.stringify(connectionMsg));
  ws.onopen = (e) => {
    console.log("Connection established");
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
    console.log(message);
    if (message["type"]) {
      if (message["type"] === "join-call") {
        checkConfirmation(message);
      } else if (message["type"] === "offer") {
        handleRecieveCall(message);
      } else if (message["type"] === "ice-candidate") {
        handleNewICECandidateMsg(message);
      }
    }
  };

  ws.onclose = (e) => {
    console.log("closed");
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
}

window.onload = () => {
  main();
};
