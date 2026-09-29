import http from 'k6/http';
import { sleep } from 'k6';

export const options = {
  vus: 100,
  duration: '3m',
};

export default function () {
  http.get('http://127.0.0.1:8000');
  sleep(0.2);
}