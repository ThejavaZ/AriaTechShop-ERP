import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  stages: [
    { duration: '10s', target: 10 },
    { duration: '20s', target: 10 },
    { duration: '10s', target: 0 },
  ],
  thresholds: {
    http_req_duration: ['p(95)<5000'],
  },
};

const BASE_URL = 'http://localhost:8000';

export default function () {
  const payload = JSON.stringify({
    email: 'testuser@example.com',
    password: 'password123',
  });

  const params = {
    headers: {
      'Content-Type': 'application/json',
    },
  };

  const res = http.post(`${BASE_URL}/api/login`, payload, params);

  check(res, {
    'status code 200/201/302': (r) => r.status === 200 || r.status === 201 || r.status === 302,
    'response time < 5s': (r) => r.timings.duration < 5000,
  });

  sleep(1);
}