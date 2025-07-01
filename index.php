<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Upload - 写真アップロード</title>
    <link rel="icon" href="data:,">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
            text-align: center;
        }

        h1 {
            color: #333;
            margin-bottom: 30px;
            font-size: 2.5rem;
            font-weight: 300;
        }

        .upload-area {
            border: 3px dashed #667eea;
            border-radius: 15px;
            padding: 60px 20px;
            margin: 30px 0;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .upload-area:hover {
            border-color: #764ba2;
            background: rgba(102, 126, 234, 0.05);
            transform: translateY(-2px);
        }

        .upload-area.dragover {
            border-color: #764ba2;
            background: rgba(102, 126, 234, 0.1);
            transform: scale(1.02);
        }

        .upload-icon {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 20px;
        }

        .upload-text {
            color: #666;
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .upload-subtext {
            color: #999;
            font-size: 0.9rem;
        }

        #fileInput {
            display: none;
        }

        .btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .preview-container {
            margin-top: 30px;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .image-preview {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .image-preview:hover {
            transform: scale(1.05);
        }

        .image-preview img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            background-color: #f5f5f5;
        }

        .crop-controls {
            position: absolute;
            top: 10px;
            left: 10px;
            display: flex;
            gap: 5px;
        }

        .crop-btn {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 15px;
            padding: 5px 10px;
            font-size: 0.8rem;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #667eea;
            font-weight: 500;
        }

        .crop-btn:hover {
            background: #667eea;
            color: white;
        }

        .crop-btn.active {
            background: #667eea;
            color: white;
        }

        .image-info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.7));
            color: white;
            padding: 20px 15px 15px;
            font-size: 0.9rem;
        }

        .delete-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            font-size: 1.2rem;
            color: #ff4757;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .delete-btn:hover {
            background: #ff4757;
            color: white;
            transform: scale(1.1);
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background: rgba(102, 126, 234, 0.2);
            border-radius: 3px;
            margin: 20px 0;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            background: linear-gradient(45deg, #667eea, #764ba2);
            width: 0%;
            border-radius: 3px;
            transition: width 0.3s ease;
        }

        .stats {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            padding: 20px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 15px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #667eea;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .form-section {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .input-group {
            flex: 1;
            text-align: left;
        }

        .input-group label {
            display: block;
            color: #333;
            font-weight: 500;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .input-group input {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .input-group select {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e1e8ed;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 12px center;
            background-repeat: no-repeat;
            background-size: 16px;
            padding-right: 40px;
        }

        .input-group input:focus,
        .input-group select:focus {
            outline: none;
            border-color: #667eea;
            background: rgba(255, 255, 255, 1);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .input-group input:valid,
        .input-group select:valid {
            border-color: #2ed573;
        }

        .submit-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(102, 126, 234, 0.2);
        }

        .submit-btn {
            background: linear-gradient(45deg, #2ed573, #17d35e);
            font-size: 1.1rem;
            padding: 15px 40px;
        }

        .submit-btn:hover {
            box-shadow: 0 10px 20px rgba(46, 213, 115, 0.3);
        }

        .submit-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .loading-status {
            margin: 10px 0;
            padding: 10px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 10px;
            color: #667eea;
            font-size: 0.9rem;
            display: none;
        }

        .face-detection-info {
            position: absolute;
            top: 40px;
            right: 10px;
            background: rgba(46, 213, 115, 0.9);
            color: white;
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .face-detection-info.no-face {
            background: rgba(255, 193, 7, 0.9);
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 2rem;
            }

            .upload-area {
                padding: 40px 20px;
            }

            .preview-container {
                grid-template-columns: 1fr;
            }

            .form-section {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📸 Photo Upload</h1>
        
        <div class="loading-status" id="loadingStatus">
            🧠 AI顔検出モデルを読み込み中...
        </div>
        
        <div class="form-section">
            <div class="input-group">
                <label for="grade">学年 *</label>
                <select id="grade" required>
                    <option value="">学年を選択してください</option>
                    <option value="ほし">ほし</option>
                    <option value="めばえ">めばえ</option>
                    <option value="年中">年中</option>
                    <option value="年長">年長</option>
                </select>
            </div>
            <div class="input-group">
                <label for="lastName">園児の苗字(Family name) *</label>
                <input type="text" id="lastName" placeholder="山田" required>
            </div>
            <div class="input-group">
                <label for="firstName">園児の名前(Given name) *</label>
                <input type="text" id="firstName" placeholder="太郎" required>
            </div>
        </div>
        
        <div class="upload-area" id="uploadArea">
            <div class="upload-icon">☁️</div>
            <div class="upload-text">写真をドラッグ&ドロップ</div>
            <div class="upload-subtext">または</div>
            <button class="btn" onclick="document.getElementById('fileInput').click()">
                ファイルを選択
            </button>
            <div class="upload-subtext">プレビューが表示されるまでに数秒かかります！</div>
        </div>

        <input type="file" id="fileInput" multiple accept="image/*">
        
        <div class="progress-bar" id="progressBar" style="display: none;">
            <div class="progress-fill" id="progressFill"></div>
        </div>

        <div class="stats" id="stats" style="display: none;">
            <div class="stat-item">
                <div class="stat-number" id="totalImages">0</div>
                <div class="stat-label">画像数</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="totalSize">0 KB</div>
                <div class="stat-label">合計サイズ</div>
            </div>
        </div>

        <div class="preview-container" id="previewContainer"></div>

        <button class="btn" id="clearAll" onclick="clearAllImages()" style="display: none;">
            すべてクリア
        </button>

        <div class="submit-section">
            <button class="btn submit-btn" id="submitBtn" onclick="submitForm()">
                📤 送信する
            </button>
        </div>
    </div>

    <!-- Face-API.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

    <script>
        let uploadedImages = [];
        let totalSize = 0;
        let faceApiLoaded = false;

        // DOM要素の取得
        const uploadArea = document.getElementById('uploadArea');
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');
        const progressBar = document.getElementById('progressBar');
        const progressFill = document.getElementById('progressFill');
        const stats = document.getElementById('stats');
        const totalImagesEl = document.getElementById('totalImages');
        const totalSizeEl = document.getElementById('totalSize');
        const clearAllBtn = document.getElementById('clearAll');
        const lastNameInput = document.getElementById('lastName');
        const firstNameInput = document.getElementById('firstName');
        const gradeSelect = document.getElementById('grade');
        const submitBtn = document.getElementById('submitBtn');
        const loadingStatus = document.getElementById('loadingStatus');

        console.log('読み込み開始したよー(最初の最初)')
        window.addEventListener('DOMContentLoaded', initializeFaceAPI);
        
        // Face-API.jsの初期化
        async function initializeFaceAPI() {
            console.log('読み込み開始したよー(最初)')
            try {
                loadingStatus.style.display = 'block';
                loadingStatus.textContent = '🧠 AI顔検出モデルを読み込み中...';
                
                // モデルのロード
                await Promise.all([
                    faceapi.nets.tinyFaceDetector.loadFromUri('./model'),
                    faceapi.nets.faceLandmark68Net.loadFromUri('./model'),
                    faceapi.nets.faceRecognitionNet.loadFromUri('./model'),
                    faceapi.nets.ssdMobilenetv1.loadFromUri('./model')
                ]);
                
                faceApiLoaded = true;
                console.log('読み込み開始したよー')
                loadingStatus.textContent = '✅ AI顔検出モデル読み込み完了！';
                setTimeout(() => {
                    loadingStatus.style.display = 'none';
                }, 2000);
                
                console.log('Face-API.js models loaded successfully');
            } catch (error) {
                console.error('Face-API.js loading error:', error);
                loadingStatus.textContent = '⚠️ 顔検出機能の読み込みに失敗しました（通常モードで動作）';
                setTimeout(() => {
                    loadingStatus.style.display = 'none';
                }, 3000);
            }
        }

        // ドラッグ&ドロップのイベントリスナー
        uploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            uploadArea.classList.add('dragover');
        });

        uploadArea.addEventListener('dragleave', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
        });

        uploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            uploadArea.classList.remove('dragover');
            const files = Array.from(e.dataTransfer.files);
            handleFiles(files);
        });

        // ファイル選択のイベントリスナー
        fileInput.addEventListener('change', (e) => {
            const files = Array.from(e.target.files);
            handleFiles(files);
        });

        // フォーム入力のイベントリスナー
        lastNameInput.addEventListener('input', updateSubmitButton);
        firstNameInput.addEventListener('input', updateSubmitButton);
        gradeSelect.addEventListener('change', updateSubmitButton);

        // ファイル処理メイン関数
        function handleFiles(files) {
            const imageFiles = files.filter(file => file.type.startsWith('image/'));
            
            if (imageFiles.length === 0) {
                alert('画像ファイルを選択してください。');
                return;
            }

            showProgress();
            
            imageFiles.forEach((file, index) => {
                setTimeout(() => {
                    if (file.size < 1024 * 1024 * 2) {
                        alert('ファイルサイズは2MB以上にしてください');
                        return;
                    }

                    processImage(file);
                    updateProgress((index + 1) / imageFiles.length * 100);
                    
                    if (index === imageFiles.length - 1) {
                        hideProgress();
                    }
                }, index * 500); // より長い間隔で処理（AI処理時間を考慮）
            });
        }

        // 画像処理関数
        async function processImage(file) {
            const reader = new FileReader();
            
            reader.onload = async (e) => {
                const originalSrc = e.target.result;
                
                // Face-API.jsを使用して顔検出とクロップ
                const { croppedSrc, faceDetected } = await cropImageWithFaceAPI(originalSrc);
                
                const imageData = {
                    id: Date.now() + Math.random(),
                    originalSrc: originalSrc,
                    croppedSrc: croppedSrc,
                    currentSrc: croppedSrc,
                    isCropped: true,
                    faceDetected: faceDetected,
                    name: file.name,
                    size: file.size,
                    type: file.type
                };

                uploadedImages.push(imageData);
                totalSize += file.size;
                
                createImagePreview(imageData);
                updateStats();
            };

            reader.readAsDataURL(file);
        }

        // Face-API.jsを使用した顔検出とクロップ
        async function cropImageWithFaceAPI(imageSrc) {
            return new Promise((resolve) => {
                const img = new Image();
                img.onload = async () => {
                    let faceDetected = false;
                    let croppedSrc;
                    
                    if (faceApiLoaded) {
                        try {
                            // 顔検出を実行
                            const detections = await faceapi.detectAllFaces(img, new faceapi.TinyFaceDetectorOptions())
                                .withFaceLandmarks()
                                .withFaceDescriptors();
                            
                            if (detections.length > 0) {
                                // 顔が検出された場合
                                faceDetected = true;
                                const detection = detections[0]; // 最初の顔を使用
                                console.log('検出されました')
                                croppedSrc = await cropToFaceRegionWithAPI(img, detection);
                            } else {
                                // 顔が検出されなかった場合は標準クロップ
                                const canvas = performStandardCrop(img);
                                croppedSrc = canvas.toDataURL('image/jpeg', 0.9);
                                console.log('検出されてないっす')
                            }
                        } catch (error) {
                            console.error('Face detection error:', error);
                            // エラーの場合は標準クロップ
                            const canvas = performStandardCrop(img);
                            croppedSrc = canvas.toDataURL('image/jpeg', 0.9);
                            console.log('エラーっす')
                        }
                    } else {
                        // Face-API.jsが読み込まれていない場合は標準クロップ
                        const canvas = performStandardCrop(img);
                        croppedSrc = canvas.toDataURL('image/jpeg', 0.9);
                        console.log('がちのエラーっす')
                    }
                    
                    resolve({ croppedSrc, faceDetected });
                };
                img.src = imageSrc;
            });
        }

        // Face-API.jsの検出結果を使用してクロップ
        async function cropToFaceRegionWithAPI(img, detection) {
            console.log('マージン調整するやーつに入りました')
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d', { willReadFrequently: true });
            
            // 顔のバウンディングボックスを取得
            const box = detection.detection.box;
            const landmarks = detection.landmarks;
            
            // 証明写真風のクロップ範囲を計算
            const faceWidth = box.width;
            const faceHeight = box.height;
            
            // 顔の位置から上半身を含むクロップ範囲を算出
            console.log('マージン調整するよー')
            const margin = {
                top: faceHeight * 0.3,    // 顔の上に30%のマージン
                bottom: faceHeight * 0.6,  // 顔の下に150%のマージン（上半身含む）
                left: faceWidth * 0.2,     // 顔の左右に40%ずつマージン
                right: faceWidth * 0.2
            };
            
            const cropX = Math.max(0, box.x - margin.left);
            const cropY = Math.max(0, box.y - margin.top);
            const cropWidth = Math.min(img.width - cropX, faceWidth + margin.left + margin.right);
            const cropHeight = Math.min(img.height - cropY, faceHeight + margin.top + margin.bottom);
            
            // 3:4比率に調整
            const targetRatio = 3 / 4;
            let finalWidth = cropWidth;
            let finalHeight = cropHeight;
            
            if (finalWidth / finalHeight > targetRatio) {
                finalWidth = finalHeight * targetRatio;
            } else {
                finalHeight = finalWidth / targetRatio;
            }
            
            // キャンバスサイズ設定（証明写真サイズ）
            canvas.width = 300;
            canvas.height = 400;
            
            // 白背景
            ctx.fillStyle = 'white';
            ctx.fillRect(0, 0, 300, 400);
            
            // クロップした画像を描画
            const centerX = cropX + cropWidth / 2;
            const centerY = cropY + cropHeight / 2;
            const sourceX = centerX - finalWidth / 2;
            const sourceY = centerY - finalHeight / 2;
            
            ctx.drawImage(
                img,
                sourceX, sourceY, finalWidth, finalHeight,
                0, 0, 300, 400
            );
            
            return canvas.toDataURL('image/jpeg', 0.95);
        }

        // 標準クロップ（Face-API.js使用不可時）
        function performStandardCrop(img) {
            const canvas = document.createElement('canvas');
            const ctx = canvas.getContext('2d', { willReadFrequently: true });
            
            const originalWidth = img.width;
            const originalHeight = img.height;
            const targetRatio = 3 / 4;
            
            let sourceWidth, sourceHeight, sourceX, sourceY;
            
            if (originalWidth / originalHeight > targetRatio) {
                sourceHeight = originalHeight;
                sourceWidth = originalHeight * targetRatio;
                sourceX = (originalWidth - sourceWidth) / 2;
                sourceY = 0;
            } else {
                sourceWidth = originalWidth;
                sourceHeight = originalWidth / targetRatio;
                sourceX = 0;
                sourceY = (originalHeight - sourceHeight) / 2;
            }
            
            canvas.width = 300;
            canvas.height = 400;
            
            ctx.fillStyle = 'white';
            ctx.fillRect(0, 0, 300, 400);
            
            ctx.drawImage(
                img,
                sourceX, sourceY, sourceWidth, sourceHeight,
                0, 0, 300, 400
            );
            
            return canvas;
        }

        // プレビュー作成関数
        function createImagePreview(imageData) {
            const previewDiv = document.createElement('div');
            previewDiv.className = 'image-preview';
            previewDiv.setAttribute('data-id', imageData.id);

            const faceDetectionBadge = imageData.faceDetected 
                ? '<div class="face-detection-info">顔検出</div>'
                : '<div class="face-detection-info no-face">標準</div>';

            previewDiv.innerHTML = `
                <img src="${imageData.currentSrc}" alt="${imageData.name}">
                <div class="crop-controls">
                    <button class="crop-btn ${imageData.isCropped ? 'active' : ''}" onclick="toggleCrop(${imageData.id}, true)">3:4</button>
                    <button class="crop-btn ${!imageData.isCropped ? 'active' : ''}" onclick="toggleCrop(${imageData.id}, false)">元</button>
                </div>
                ${faceDetectionBadge}
                <button class="delete-btn" onclick="deleteImage(${imageData.id})">&times;</button>
                <div class="image-info">
                    <div><strong>${imageData.name}</strong></div>
                    <div>${formatFileSize(imageData.size)} ${imageData.isCropped ? '(3:4)' : '(元画像)'}</div>
                    ${imageData.faceDetected ? '<div style="font-size: 0.8rem; color: #2ed573;">🤖 AI顔検出適用済み</div>' : ''}
                </div>
            `;

            previewContainer.appendChild(previewDiv);
            
            // アニメーション効果
            setTimeout(() => {
                previewDiv.style.opacity = '0';
                previewDiv.style.transform = 'scale(0.8)';
                previewDiv.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    previewDiv.style.opacity = '1';
                    previewDiv.style.transform = 'scale(1)';
                }, 10);
            }, 10);
        }

        // クロップ切り替え関数
        function toggleCrop(imageId, shouldCrop) {
            const imageIndex = uploadedImages.findIndex(img => img.id === imageId);
            if (imageIndex === -1) return;
            
            const imageData = uploadedImages[imageIndex];
            const previewElement = document.querySelector(`[data-id="${imageId}"]`);
            const imgElement = previewElement.querySelector('img');
            const infoElement = previewElement.querySelector('.image-info div:nth-child(2)');
            const cropButtons = previewElement.querySelectorAll('.crop-btn');
            
            if (shouldCrop) {
                imageData.currentSrc = imageData.croppedSrc;
                imageData.isCropped = true;
                imgElement.src = imageData.croppedSrc;
                infoElement.textContent = `${formatFileSize(imageData.size)} (3:4)`;
                cropButtons[0].classList.add('active');
                cropButtons[1].classList.remove('active');
            } else {
                imageData.currentSrc = imageData.originalSrc;
                imageData.isCropped = false;
                imgElement.src = imageData.originalSrc;
                infoElement.textContent = `${formatFileSize(imageData.size)} (元画像)`;
                cropButtons[0].classList.remove('active');
                cropButtons[1].classList.add('active');
            }
            
            uploadedImages[imageIndex] = imageData;
        }

        // 画像削除関数
        function deleteImage(imageId) {
            const imageIndex = uploadedImages.findIndex(img => img.id === imageId);
            if (imageIndex !== -1) {
                totalSize -= uploadedImages[imageIndex].size;
                uploadedImages.splice(imageIndex, 1);
                
                const previewElement = document.querySelector(`[data-id="${imageId}"]`);
                if (previewElement) {
                    previewElement.style.transform = 'scale(0)';
                    previewElement.style.opacity = '0';
                    setTimeout(() => {
                        previewElement.remove();
                    }, 300);
                }
                
                updateStats();
            }
        }

        // 全削除関数
        function clearAllImages() {
            if (uploadedImages.length === 0) return;
            
            if (confirm('すべての画像を削除しますか？')) {
                uploadedImages = [];
                totalSize = 0;
                previewContainer.innerHTML = '';
                updateStats();
            }
        }

        // 統計更新関数
        function updateStats() {
            if (uploadedImages.length > 0) {
                stats.style.display = 'flex';
                clearAllBtn.style.display = 'inline-block';
                totalImagesEl.textContent = uploadedImages.length;
                totalSizeEl.textContent = formatFileSize(totalSize);
            } else {
                stats.style.display = 'none';
                clearAllBtn.style.display = 'none';
            }
            updateSubmitButton();
        }

        // 送信ボタンの状態更新
        function updateSubmitButton() {
            const lastName = lastNameInput.value.trim();
            const firstName = firstNameInput.value.trim();
            const grade = gradeSelect.value;
            const hasImages = uploadedImages.length > 0;
            
            if (lastName && firstName && grade && hasImages) {
                submitBtn.disabled = false;
                submitBtn.textContent = '📤 送信する';
            } else {
                submitBtn.disabled = true;
                if (!lastName || !firstName) {
                    submitBtn.textContent = '📝 名前を入力してください';
                } else if (!grade) {
                    submitBtn.textContent = '🎓 学年を選択してください';
                } else if (!hasImages) {
                    submitBtn.textContent = '📸 写真を追加してください';
                }
            }
        }

        // フォーム送信関数
        function submitForm() {
            const lastName = lastNameInput.value.trim();
            const firstName = firstNameInput.value.trim();
            const grade = gradeSelect.value;
            
            if (!lastName || !firstName) {
                alert('苗字と名前を入力してください。');
                return;
            }
            
            if (!grade) {
                alert('学年を選択してください。');
                return;
            }
            
            if (uploadedImages.length === 0) {
                alert('写真を追加してください。');
                return;
            }

            // 送信データの準備
            const formData = {
                lastName: lastName,
                firstName: firstName,
                fullName: lastName + ' ' + firstName,
                grade: grade,
                images: uploadedImages.map(img => ({
                    name: img.name,
                    size: img.size,
                    type: img.type,
                    isCropped: img.isCropped,
                    src: img.currentSrc // 現在選択されている画像（クロップ済みまたは元画像）
                })),
                totalImages: uploadedImages.length,
                totalSize: totalSize,
                timestamp: new Date().toISOString()
            };

            // 実際のサーバー送信処理をここに実装
            console.log('送信データ:', formData);

            uploadedImages.forEach(imageData => {
                fetch('upload.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ image: imageData.currentSrc, userinfo: grade + '_' + lastName + '_' + firstName })
                })
                .then(res => res.text())
                .then(data => {
                    alert('アップロード成功: ' + data);
                })
                .catch(err => {
                    console.error(err);
                    alert('アップロード失敗');
                });
            });


            // 送信成功のメッセージ
            alert(`${formData.fullName}様（${formData.grade}）\n${uploadedImages.length}枚の写真を送信しました！\n\n送信データ:\n- 名前: ${formData.fullName}\n- 学年: ${formData.grade}\n- 画像数: ${formData.totalImages}枚\n- 合計サイズ: ${formatFileSize(formData.totalSize)}`);
            
            // フォームリセット（オプション）
            // resetForm();
        }

        // フォームリセット関数
        function resetForm() {
            lastNameInput.value = '';
            firstNameInput.value = '';
            gradeSelect.value = '';
            uploadedImages = [];
            totalSize = 0;
            previewContainer.innerHTML = '';
            updateStats();
        }

        // プログレスバー表示
        function showProgress() {
            progressBar.style.display = 'block';
            progressFill.style.width = '0%';
        }

        // プログレスバー更新
        function updateProgress(percent) {
            progressFill.style.width = percent + '%';
        }

        // プログレスバー非表示
        function hideProgress() {
            setTimeout(() => {
                progressBar.style.display = 'none';
            }, 500);
        }

        // ファイルサイズフォーマット関数
        function formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }

        // ページ読み込み時のアニメーション
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('.container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            container.style.transition = 'all 0.6s ease';
            
            setTimeout(() => {
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
            
            // 初期状態で送信ボタンを無効化
            updateSubmitButton();
        });
    </script>
</body>
</html>
