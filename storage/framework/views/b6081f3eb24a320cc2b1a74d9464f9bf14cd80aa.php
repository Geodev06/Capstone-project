<style>
    .a-container {
        height: 40px;
        width: 40px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: dodgerblue;
        border-radius: 100px;
        color: wheat;
    }

    #pre::-webkit-scrollbar {
        width: 2px;
        height: 4px;
    }

    #pre::-webkit-scrollbar-track {
        background-color: transparent;
    }

    #pre::-webkit-scrollbar-thumb {
        background-color: dodgerblue;
    }
</style>
<?php for($i=0; $i< 5; $i++): ?> <div class="marquee-item p-3">
    <div class="d-flex justify-content-between align-items-center">
        <div class="a-container"><?php echo e($feedback_data[$i]['user_name'][0]); ?></div>
        <div class="d-flex flex-column">
            <p class="text-dark"><?php echo e($feedback_data[$i]['user_name']); ?></p>

            <?php if($feedback_data[$i]['rating']==='terrible'): ?>
            <div class="d-flex">
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bx-star "></i>
                <i class="bx bx-star "></i>
                <i class="bx bx-star"></i>
                <i class="bx bx-star"></i>
            </div>
            <p class="text-dark">Terrible!</p>
            <?php endif; ?>

            <?php if($feedback_data[$i]['rating']==='poor'): ?>
            <div class="d-flex">
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bx-star "></i>
                <i class="bx bx-star"></i>
                <i class="bx bx-star"></i>
            </div>
            <p class="text-info">Poor!</p>
            <?php endif; ?>


            <?php if($feedback_data[$i]['rating']==='good'): ?>
            <div class="d-flex">
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bx-star"></i>
                <i class="bx bx-star"></i>
            </div>
            <p class="text-success">Good!</p>
            <?php endif; ?>

            <?php if($feedback_data[$i]['rating']==='great'): ?>
            <div class="d-flex">
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bx-star"></i>
            </div>
            <p class="text-success">Great!</p>
            <?php endif; ?>

            <?php if($feedback_data[$i]['rating']==='excellent'): ?>
            <div class="d-flex">
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
                <i class="bx bxs-star text-warning"></i>
            </div>
            <p class="text-success">Excellent!</p>
            <?php endif; ?>
        </div>

    </div>

    <pre id="pre">
    <?php echo e($feedback_data[$i]['comment']); ?>

    </pre>
    </div>
    <?php endfor; ?><?php /**PATH C:\Users\sarah\Desktop\tanawsystem\tanawsystem\resources\views/layouts/ratings.blade.php ENDPATH**/ ?>