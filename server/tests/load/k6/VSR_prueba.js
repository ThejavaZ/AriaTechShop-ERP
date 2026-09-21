import http from 'k6/http';
import { check, sleep } from 'k6';

export const options = {
  vus: 5, // Mínimo 5 usuarios virtuales como pide la consigna
  duration: '30s',
  thresholds: {
    http_req_duration: ['p(95)<5000'], // Regla obligatoria: p95 menor a 5s
  },
};

export default function (){
  // Asegúrate de que el servidor Laravel esté corriendo localmente (php artisan serve)
  const res = http.get('http://127.0.0.1:8000/api/repairs');

//   console.log(`Status: ${res.status} | Body: ${res.body.substring(0, 150)}`);

  check(res, {
    'status es 200': (r) => r.status === 200,
  });

  sleep(1);
}