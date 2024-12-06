import http from 'k6/http';
import { sleep } from 'k6';

export const options = {
  // Key configurations for Stress in this section
  stages: [
    { duration: '3m', target: 800 }, // traffic ramp-up from 1 to a higher 800 users over 3 minutes.
    { duration: '2m', target: 150 },
    { duration: '4m', target: 180 },
    { duration: '30s', target: 180 },
    { duration: '30s', target: 0 }, // ramp-down to 0 users
  ],
};

export default () => {
  const urlRes = http.get('https://k31.my.id');
  sleep(1);
};
