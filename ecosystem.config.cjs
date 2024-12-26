module.exports = {
  apps: [
    {
      name: 'fundmanagement',
      script: 'artisan',
      args: 'serve --host=0.0.0.0 --port=8001',
      interpreter: 'php',
      exec_mode: 'fork',
      cwd: '/home/ubuntu/fundmanagement',
      env: {
        APP_ENV: 'local',
        APP_DEBUG: 'true',
        APP_KEY: 'base64:RZ6ty6ZqxtSBMMPV3QlZQ1eUJWl5MC7wdpH7SJy/Wos=',
        LOG_CHANNEL: 'stack',
      },
    },
  ],
};
