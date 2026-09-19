import http from 'k6/http';
import { check } from 'k6';

export const options = {
    vus: 10,
    duration: '30s',

    thresholds: {
        http_req_duration: ['p(95)<5000'],
        http_req_failed: ['rate<0.01'],
    },
};

export default function () {
    const response = http.get('http://127.0.0.1:8000/api/sales');

    check(response, {
        'status is 200': (r) => r.status === 200,
    });
}